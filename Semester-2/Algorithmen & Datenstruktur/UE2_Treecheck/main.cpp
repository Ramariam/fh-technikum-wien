#include <iostream>
#include <fstream>
#include <vector>
#include <algorithm>
#include <numeric>

#define SPACE 10 // Konstante f�r den Abstand zwischen den Ebenen im 2D-Druck des Baums

using namespace std;

// Definition der TreeNode-Klasse
class TreeNode {
public:
    int value; // Wert des Knotens
    TreeNode* left; // Zeiger auf den linken Kindknoten
    TreeNode* right; // Zeiger auf den rechten Kindknoten

    // Konstruktoren
    TreeNode() {
        value = 0;
        left = NULL;
        right = NULL;
    }
    TreeNode(int v) {
        value = v;
        left = NULL;
        right = NULL;
    }
};

// Definition der AVLTree-Klasse
class AVLTree {
public:
    TreeNode* root; // Zeiger auf die Wurzel des Baums
    bool isAVL; // Um zu �berpr�fen, ob der Baum die AVL-Eigenschaften erf�llt
    vector<int> values; // Speichert Knotenwerte f�r statistische Berechnungen

    // Konstruktor
    AVLTree() : root(nullptr), isAVL(true) {}

    // Methode zur Berechnung der H�he eines Baumes
    int height(TreeNode* r) {
        if (r == nullptr)
            return -1;
        int lheight = height(r->left);
        int rheight = height(r->right);
        return 1 + max(lheight, rheight);
    }

    // Methode zur Berechnung des Balancefaktors eines Knotens
    int getBalanceFactor(TreeNode* n) {
        if (n == nullptr)
            return 0;
        return height(n->left) - height(n->right);
    }

    // Rechtsrotation um den Knoten y
    TreeNode* rightRotate(TreeNode* y) {
        TreeNode* x = y->left;
        TreeNode* T2 = x->right;
        x->right = y;
        y->left = T2;
        return x;
    }

    // Linksrotation um den Knoten x
    TreeNode* leftRotate(TreeNode* x) {
        TreeNode* y = x->right;
        TreeNode* T2 = y->left;
        y->left = x;
        x->right = T2;
        return y;
    }

    // Methode zum Einf�gen eines Knotens in den Baum
    TreeNode* insert(TreeNode* r, int val) {
        if (r == nullptr) {
            TreeNode* new_node = new TreeNode(val);
            values.push_back(val); // Wert f�r statistische Analyse speichern
            return new_node;
        }
        if (val < r->value) {
            r->left = insert(r->left, val);
        } else if (val > r->value) {
            r->right = insert(r->right, val);
        } else {
            return r; // Direktes Zur�ckgeben von r, um ein NULL-Zur�ck zu vermeiden
        }
        return balanceTree(r, val); // Baum nach dem Einf�gen ausbalancieren
    }

    // Rekursive Suche nach einem Wert im Baum
    TreeNode* recursiveSearch(TreeNode* r, int val) {
        if (r == nullptr || r->value == val)
            return r;
        else if (val < r->value)
            return recursiveSearch(r->left, val);
        else
            return recursiveSearch(r->right, val);
    }

    // Baum nach dem Einf�gen eines Werts ausbalancieren
    TreeNode* balanceTree(TreeNode* r, int val) {
        int bf = getBalanceFactor(r);
        if (bf > 1 && val < r->left->value) {
            return rightRotate(r);
        } else if (bf < -1 && val > r->right->value) {
            return leftRotate(r);
        } else if (bf > 1 && val > r->left->value) {
            r->left = leftRotate(r->left);
            return rightRotate(r);
        } else if (bf < -1 && val < r->right->value) {
            r->right = rightRotate(r->right);
            return leftRotate(r);
        }
        return r; // Ausgeglichener Unterbaum zur�ckgeben
    }

    // Methode zum Finden des Knotens mit dem kleinsten Wert im Teilbaum
    TreeNode* minValueNode(TreeNode* node) {
        TreeNode* current = node;
        while (current && current->left != nullptr) {
            current = current->left;
        }
        return current;
    }

    // Methode zum Drucken der Balancefaktoren aller Knoten im Baum
    void printBalanceFactors(TreeNode* r) {
        if (r != nullptr) {
            printBalanceFactors(r->left);
            int bf = getBalanceFactor(r);
            cout << "bal(" << r->value << ") = " << bf;
            if (bf < -1 || bf > 1) {
                cout << " (AVL violation!)";
                isAVL = false;
            }
            cout << endl;
            printBalanceFactors(r->right);
        }
    }

    // Methode zum �berpr�fen des AVL-Status des Baumes
    void checkAVLStatus() {
        isAVL = true; // Zur�cksetzen vor dem �berpr�fen
        printBalanceFactors(root);
        cout << "Ausgabe von AVL: " << (isAVL ? "yes" : "no") << endl;
    }

    // Methode zum Drucken statistischer Informationen �ber den Baum
    void printStatistics() {
        if (values.empty()) return;
        int min_val = *min_element(values.begin(), values.end());
        int max_val = *max_element(values.begin(), values.end());
        double avg_val = accumulate(values.begin(), values.end(), 0.0) / values.size();
        cout << "min: " << min_val << ", max: " << max_val << ", avg: " << avg_val << endl;
    }

    // Methode zum Lesen von Werten aus einer Datei und Einf�gen in den Baum
    void readAndInsertFromFile(const string& filename) {
        ifstream file(filename);
        if (!file.is_open()) {
            cout << "Fehler beim �ffnen der Datei!" << endl;
            return;
        }

        int value;
        while (file >> value) {
            root = insert(root, value);
        }

        file.close();
    }

    // Methode zum zweidimensionalen Drucken des Baumes
    void print2D(TreeNode* r, int space) {
        if (r == NULL) // Basisfall
            return;
        space += SPACE; // Abstand zwischen den Ebenen erh�hen
        print2D(r->right, space); // Zuerst rechtes Kind bearbeiten
        cout << endl;
        for (int i = SPACE; i < space; i++) // Abstand f�r den aktuellen Knoten einf�gen
            cout << " ";
        cout << r->value << "\n"; // Wert des Knotens ausgeben
        print2D(r->left, space); // Linkes Kind bearbeiten
    }

    // Methode zum Drucken des Baumes in vordefinierten Reihenfolgen (Pre-, In-, Post-Order)
    // und Breitensuche
    void printGivenLevel(TreeNode* r, int level) {
        if (r == NULL)
            return;
        else if (level == 0)
            cout << r->value << " ";
        else
        {
            printGivenLevel(r->left, level - 1);
            printGivenLevel(r->right, level - 1);
        }
    }
    void printLevelOrderBFS(TreeNode* r) {
        int h = height(r);
        for (int i = 0; i <= h; i++)
            printGivenLevel(r, i);
    }

    // Iterative Suche nach einem Wert im Baum
    TreeNode* iterativeSearch(int v) {
        if (root == NULL) {
            return root;
        } else {
            TreeNode* temp = root;
            while (temp != NULL) {
                if (v == temp->value) {
                    return temp;
                } else if (v < temp->value) {
                    temp = temp->left;
                } else {
                    temp = temp->right;
                }
            }
            return NULL;
        }
    }

};

// Hauptfunktion
int main() {
    AVLTree obj; // Instanz der AVLTree-Klasse erstellen
    obj.readAndInsertFromFile("suchbaum.txt"); // Werte aus einer Datei lesen und in den Baum einf�gen
    obj.readAndInsertFromFile("subtree.txt"); // Werte aus einer anderen Datei lesen und in den Baum einf�gen

    int option, val;

    // Men�auswahl f�r Operationen auf dem AVL-Baum
    do {
        cout << "Welche Operation m�chten Sie ausf�hren? "
             << "W�hlen Sie die Optionen aus. Geben Sie 0 ein, um das Programm zu beenden." << endl;
        cout << "1. Knoten einf�gen" << endl;
        cout << "2. Knoten suchen" << endl;
        cout << "3. AVL-Baum-Balancefaktoren drucken und AVL-Verletzungen �berpr�fen" << endl;
        cout << "4. Baumh�he" << endl;
        cout << "5. Statistiken drucken" << endl;
        cout << "0. Programm beenden" << endl;

        cin >> option;

        switch (option) {
        case 0:
            break;
        case 1: {
            cout << "AVL EINF�GEN" << endl;
            cout << "Geben Sie den Wert des TREE NODE ein, der in den AVL-Baum eingef�gt werden soll: ";
            cin >> val;
            obj.root = obj.insert(obj.root, val); // Knoten in den AVL-Baum einf�gen
            obj.checkAVLStatus(); // AVL-Eigenschaften �berpr�fen
            break;
        }
        case 2: {
            cout << "SUCHE" << endl;
            cout << "Geben Sie den Wert des TREE NODE ein, der im AVL-Baum gesucht werden soll: ";
            cin >> val;
            TreeNode* new_node = obj.recursiveSearch(obj.root, val); // Suche nach einem Knoten im Baum
            if (new_node != nullptr) {
                cout << "Wert gefunden" << endl << "Teilbaum gefunden!"<< endl;
            } else {
                cout << "Wert NICHT gefunden" << endl << "Teilbaum NICHT gefunden!"<< endl;
            }
            break;
        }
        case 3:
            obj.checkAVLStatus(); // AVL-Eigenschaften �berpr�fen
            break;
        case 4:
            cout << "BAUMH�HE" << endl;
            cout << "H�he: " << obj.height(obj.root) << endl; // Baumh�he berechnen und ausgeben
            break;
        case 5:
            obj.printStatistics(); // Statistische Informationen �ber den Baum drucken
            break;
        default:
            cout << "Geben Sie eine g�ltige Option ein" << endl;
        }

    } while (option != 0); // Schleife wird fortgesetzt, bis der Benutzer 0 eingibt, um das Programm zu beenden

    return 0;
}
