#include <iostream>
#include <fstream>
#include <sstream>
#include <vector>
#include <unordered_map>
#include <unordered_set>
#include <queue>
#include <tuple>
#include <limits>
#include <string>
#include <algorithm>
#include <regex>
#include <chrono>

using namespace std;

struct Edge {
    string line;
    string to;
    int cost;
};

struct Node {
    string station;
    int cost;
    vector<tuple<string, int, string>> path;
    string line;

    bool operator>(const Node& other) const {
        return cost > other.cost;
    }
};

unordered_map<string, vector<Edge>> readGraph(const string& filename) {
    unordered_map<string, vector<Edge>> graph;
    ifstream file(filename);
    if (!file.is_open()) {
        cerr << "Error opening file: " << filename << endl;
        exit(1);
    }

    string line;
    regex re("\"(.*?)\" (\\d+)");
    while (getline(file, line)) {
        stringstream ss(line);
        string lineName, rest;
        getline(ss, lineName, ':');
        lineName.erase(remove_if(lineName.begin(), lineName.end(), ::isspace), lineName.end());

        getline(ss, rest);
        sregex_iterator next(rest.begin(), rest.end(), re);
        sregex_iterator end;

        string prevStation;
        while (next != end) {
            smatch match = *next;
            string station = match[1].str();
            int cost = stoi(match[2].str());
            next++;
            if (!prevStation.empty()) {
                graph[prevStation].push_back({lineName, station, cost});
                graph[station].push_back({lineName, prevStation, cost});
            }
            prevStation = station;
        }
    }
    return graph;
}

vector<tuple<string, int, string>> shortestPath(const unordered_map<string, vector<Edge>>& graph, const string& start, const string& goal) {
    const int lineSwitchPenalty = 5;
    priority_queue<Node, vector<Node>, greater<Node>> pq;
    unordered_set<string> visited;

    pq.push({start, 0, {}, ""});

    while (!pq.empty()) {
        Node current = pq.top();
        pq.pop();

        if (visited.find(current.station) != visited.end()) {
            continue;
        }

        visited.insert(current.station);

        vector<tuple<string, int, string>> currentPath = current.path;
        currentPath.push_back({current.station, current.cost, current.line});

        if (current.station == goal) {
            return currentPath;
        }

        for (const Edge& edge : graph.at(current.station)) {
            int switchCost = (current.line != edge.line && !current.line.empty()) ? lineSwitchPenalty : 0;
            pq.push({edge.to, current.cost + edge.cost + switchCost, currentPath, edge.line});
        }
    }

    return {};
}

void findPath(const string& filename, const string& start, const string& goal) {
    unordered_map<string, vector<Edge>> graph = readGraph(filename);
    vector<tuple<string, int, string>> path = shortestPath(graph, start, goal);

    if (!path.empty()) {
        int totalCost = get<1>(path.back());
        string previousLine;
        for (size_t i = 1; i < path.size(); ++i) {
            string station = get<0>(path[i]);
            int cost = get<1>(path[i]);
            string line = get<2>(path[i]);
            if (line != previousLine && i != 1) {
                cout << "Umstieg auf Linie " << line << " an Station " << station << endl;
            }
            cout << "Fahre von " << get<0>(path[i - 1]) << " nach " << station << " mit Linie " << line << " (Kosten: " << cost << ")" << endl;
            previousLine = line;
        }
        cout << "Ende: " << goal << endl;
        cout << "Gesamtkosten: " << totalCost << endl;
    } else {
        cout << "Kein Pfad gefunden" << endl;
    }
}

pair<string, string> getUserInput() {
    string startStation, endStation;
    cout << "Bitte geben Sie die Startstation ein: ";
    getline(cin, startStation);
    cout << "Bitte geben Sie die Zielstation ein: ";
    getline(cin, endStation);
    return {startStation, endStation};
}

int main() {
    while (true) {
        auto [start, end] = getUserInput();
        cout << "Start: " << start << endl;

        auto start_time = chrono::high_resolution_clock::now();
        findPath("stationen.txt", start, end);
        auto end_time = chrono::high_resolution_clock::now();

        chrono::duration<double> elapsed_time = end_time - start_time;
        cout << "Laufzeit: " << elapsed_time.count() << " Sekunden" << endl;

        cout << "Möchten Sie weiterfahren (w), neu anfangen (n) oder beenden (x)? ";
        string userChoice;
        getline(cin, userChoice);

        if (userChoice == "w") {
            start = end;
        } else if (userChoice == "n") {
            continue;
        } else if (userChoice == "x") {
            break;
        } else {
            cout << "Ungültige Eingabe. Das Programm wird beendet." << endl;
            break;
        }
    }

    return 0;
}
