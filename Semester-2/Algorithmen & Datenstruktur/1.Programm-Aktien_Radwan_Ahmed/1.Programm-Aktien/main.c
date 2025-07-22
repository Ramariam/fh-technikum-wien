#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define TABLE_SIZE 1019 // Primzahl nahe 1000 für effiziente Hashtabelle
#define MAX_SYMBOL_LENGTH 20
#define NUM_DAYS 30 // Angenommen, dies ist die korrekte Anzahl der Tage
#define MAX_FILENAME_LENGTH 100
#define MAX_LINE_LENGTH 1000
#define PLOT_HEIGHT 10
#define PLOT_WIDTH 30

typedef struct {
    char date[11]; // Im Format YYYY-MM-DD
    float open;
    float high;
    float low;
    float close;
    int volume;
    float adjClose;
} DailyStockData;

typedef struct Stock {
    char name[50];
    char wkn[20]; // Wertpapierkennnummer
    char symbol[MAX_SYMBOL_LENGTH]; // Kürzel der Aktie
    DailyStockData data[NUM_DAYS]; // Kursdaten der letzten 30 Tage
    int dataCount; // Anzahl der tatsächlich gespeicherten Tage
    struct Stock* next; // Nächster Eintrag für den Fall von Kollisionen in der Hashtabelle
} Stock;

typedef struct {
    Stock* stocks[TABLE_SIZE];
} HashTable;

unsigned int hash(const char* key) {
    unsigned long hash = 0;
    while (*key) {
        hash = (hash * 31) + *key++; // Einfache Hash-Berechnung
    }
    return hash % TABLE_SIZE;
}

unsigned int quadratic_probe(unsigned int index, unsigned int attempt, unsigned int tableSize) {
    // Eine einfache quadratische Sondierungsfunktion
    return (index + attempt * attempt) % tableSize;
}

Stock* create_stock(const char* name, const char* wkn, const char* symbol) {
    Stock* stock = malloc(sizeof(Stock));
    if (stock) {
        strncpy(stock->name, name, 49);
        strncpy(stock->wkn, wkn, 19);
        strncpy(stock->symbol, symbol, MAX_SYMBOL_LENGTH - 1);
        stock->dataCount = 0; // Initialisiere dataCount mit 0
        stock->next = NULL;
    }
    return stock;
}

void insert_stock(HashTable* table, Stock* stock) {
    if (!table || !stock) return;
    unsigned int index = hash(stock->symbol);
    stock->next = table->stocks[index]; // Füge am Anfang der Liste ein
    table->stocks[index] = stock;
}

Stock* search_stock(HashTable* table, const char* symbol) {
    if (!table || !symbol) return NULL;
    unsigned int index = hash(symbol);
    Stock* current = table->stocks[index];
    while (current) {
        if (strcmp(current->symbol, symbol) == 0) {
            return current; // Gefunden
        }
        current = current->next; // Gehe zur nächsten Aktie in der Liste
    }
    return NULL; // Nicht gefunden
}

Stock* search_by_name(HashTable* hashtable, const char* name) {
    for (int i = 0; i < TABLE_SIZE; ++i) {
        for (Stock* stock = hashtable->stocks[i]; stock != NULL; stock = stock->next) {
            if (strcmp(stock->name, name) == 0) {
                return stock;
            }
        }
    }
    return NULL;
}


void delete_stock(HashTable* hashtable, const char* key) {
    unsigned int index = hash(key);
    Stock *prev = NULL, *current = hashtable->stocks[index];
    while (current) {
        if (strcmp(current->symbol, key) == 0) {
            if (prev) {
                prev->next = current->next;
            } else {
                hashtable->stocks[index] = current->next;
            }
            free(current);
            printf("Stock deleted.\n");
            return;
        }
        prev = current;
        current = current->next;
    }
    printf("Stock not found.\n");
}


void init_table(HashTable* table) {
    memset(table, 0, sizeof(HashTable));
}

void free_table(HashTable* table) {
    for (int i = 0; i < TABLE_SIZE; i++) {
        Stock* current = table->stocks[i];
        while (current) {
            Stock* temp = current;
            current = current->next;
            free(temp);
        }
    }
}

void add_price_to_stock(Stock* stock, const char* date, float open, float high, float low, float close, int volume, float adjClose) {
    if (stock->dataCount < NUM_DAYS) {
        strncpy(stock->data[stock->dataCount].date, date, sizeof(stock->data[0].date) - 1);
        stock->data[stock->dataCount].date[sizeof(stock->data[0].date) - 1] = '\0'; // Sicherstellen, dass das Datum nullterminiert ist
        stock->data[stock->dataCount].open = open;
        stock->data[stock->dataCount].high = high;
        stock->data[stock->dataCount].low = low;
        stock->data[stock->dataCount].close = close;
        stock->data[stock->dataCount].volume = volume;
        stock->data[stock->dataCount].adjClose = adjClose;
        stock->dataCount++;
    } else {
        // Wenn die maximale Anzahl an Tagen erreicht ist, verschiebe alle Einträge um eins nach links
        memmove(stock->data, stock->data + 1, sizeof(DailyStockData) * (NUM_DAYS - 1));
        // Füge die neuen Daten am Ende hinzu
        int lastIndex = NUM_DAYS - 1;
        strncpy(stock->data[lastIndex].date, date, sizeof(stock->data[0].date) - 1);
        stock->data[lastIndex].date[sizeof(stock->data[0].date) - 1] = '\0';
        stock->data[lastIndex].open = open;
        stock->data[lastIndex].high = high;
        stock->data[lastIndex].low = low;
        stock->data[lastIndex].close = close;
        stock->data[lastIndex].volume = volume;
        stock->data[lastIndex].adjClose = adjClose;
    }
}



void find_min_max(float *array, int count, float *min, float *max) {
    *min = *max = array[0];
    for (int i = 1; i < count; ++i) {
        if (array[i] < *min) *min = array[i];
        if (array[i] > *max) *max = array[i];
    }
}

void display_plot(Stock* stock) {
    if (stock == NULL || stock->dataCount == 0) {
        printf("No stock data available for plotting.\n");
        return;
    }

    // Wir verwenden nur die Close-Preise für die Darstellung
    float prices[NUM_DAYS];
    for (int i = 0; i < stock->dataCount; ++i) {
        prices[i] = stock->data[i].close;
    }

    float minPrice, maxPrice;
    find_min_max(prices, stock->dataCount, &minPrice, &maxPrice);

    float range = maxPrice - minPrice;
    if (range == 0) range = 1; // Verhindert Division durch Null

    char plot[PLOT_HEIGHT][PLOT_WIDTH + 1]; // +1 für Nullterminierung
    memset(plot, ' ', sizeof(plot));

    // Initialisiere Plot-Bereich mit Leerzeichen und Nullterminierung
    for (int i = 0; i < PLOT_HEIGHT; ++i) {
        plot[i][PLOT_WIDTH] = '\0';
    }

    // Berechne und zeichne die Punkte für die Preise
    for (int i = 0; i < stock->dataCount; ++i) {
        int plotColumn = i * PLOT_WIDTH / stock->dataCount;
        float normalizedHeight = (prices[i] - minPrice) / range * (PLOT_HEIGHT - 1);
        int rowIndex = (int)normalizedHeight;
        plot[PLOT_HEIGHT - 1 - rowIndex][plotColumn] = '*';
    }

    // Zeichne Plot
    printf("ASCII-Plot for %s:\n", stock->name);
    for (int i = 0; i < PLOT_HEIGHT; ++i) {
        printf("%s\n", plot[i]);
    }
    printf("Min: %.2f, Max: %.2f\n", minPrice, maxPrice);
}


void import_data_from_csv(HashTable* hashtable) {
    const char* filename = "MSFT.csv";
    FILE* file = fopen(filename, "r");
    if (!file) {
        perror("Fehler beim Öffnen der Datei");
        return;
    }

    char buffer[MAX_LINE_LENGTH];
    // Überspringe die Kopfzeile
    fgets(buffer, MAX_LINE_LENGTH, file);

    Stock* stock = search_stock(hashtable, "MSFT");
    if (stock == NULL) {
        // Wenn nicht vorhanden, erstelle ein neues Stock-Objekt für MSFT und füge es hinzu
        stock = create_stock("Microsoft Corporation", "irrelevant", "MSFT");
        insert_stock(hashtable, stock);
    }

    while (fgets(buffer, MAX_LINE_LENGTH, file) && stock->dataCount < NUM_DAYS) {
        char* token = strtok(buffer, ",");
        if (!token) continue; // Fehlende Daten überspringen

        // Extrahiere und weise Daten zu, unter der Annahme, dass das Format ist: Datum,Open,High,Low,Close,Volume,Adj Close
        strncpy(stock->data[stock->dataCount].date, token, 10);
        stock->data[stock->dataCount].open = atof(strtok(NULL, ","));
        stock->data[stock->dataCount].high = atof(strtok(NULL, ","));
        stock->data[stock->dataCount].low = atof(strtok(NULL, ","));
        stock->data[stock->dataCount].close = atof(strtok(NULL, ","));
        stock->data[stock->dataCount].volume = atoi(strtok(NULL, ","));
        stock->data[stock->dataCount].adjClose = atof(strtok(NULL, ","));

        stock->dataCount++;
    }

    fclose(file);
}


void save_hash_table(const HashTable* hashtable, const char* filename) {
    FILE* file = fopen(filename, "w");
    if (!file) {
        printf("Could not open file %s for writing.\n", filename);
        return;
    }
    for (int i = 0; i < TABLE_SIZE; ++i) {
        Stock* stock = hashtable->stocks[i];
        while (stock != NULL) {
            // Speichere Grundinformationen der Aktie
            fprintf(file, "%s,%s,%s", stock->name, stock->wkn, stock->symbol);
            // Speichere Kursdaten der Aktie
            for (int j = 0; j < stock->dataCount; j++) {
                fprintf(file, ",%s,%.2f,%.2f,%.2f,%.2f,%d,%.2f",
                        stock->data[j].date, stock->data[j].open, stock->data[j].high,
                        stock->data[j].low, stock->data[j].close,
                        stock->data[j].volume, stock->data[j].adjClose);
            }
            fprintf(file, "\n");
            stock = stock->next;
        }
    }
    fclose(file);
      printf("Saved succesfully!\n");
}


void load_hash_table(HashTable* hashtable, const char* filename) {
    FILE* file = fopen(filename, "r");
    if (!file) {
        printf("Could not open file %s for reading.\n", filename);
        return;
    }

    char buffer[MAX_LINE_LENGTH];
    while (fgets(buffer, MAX_LINE_LENGTH, file)) {
        buffer[strcspn(buffer, "\n")] = 0; // Entferne den Zeilenumbruch am Ende
        char* token = strtok(buffer, ",");
        char name[50], wkn[20], symbol[MAX_SYMBOL_LENGTH];

        strncpy(name, token, sizeof(name) - 1); name[sizeof(name)-1] = '\0';
        strncpy(wkn, strtok(NULL, ","), sizeof(wkn) - 1); wkn[sizeof(wkn)-1] = '\0';
        strncpy(symbol, strtok(NULL, ","), sizeof(symbol) - 1); symbol[sizeof(symbol)-1] = '\0';

        // Erstelle eine neue Aktie und füge sie der Hashtabelle hinzu
        Stock* stock = create_stock(name, wkn, symbol);
        insert_stock(hashtable, stock);

        // Überspringe Grundinformationen und lese Kursdaten
        while ((token = strtok(NULL, ",")) != NULL) {
            // Gehe davon aus, dass jede Aktie nur ein Tagesdatensatz folgt
            strncpy(stock->data[0].date, token, 10); // Nächstes Token ist das Datum
            stock->data[0].open = atof(strtok(NULL, ","));
            stock->data[0].high = atof(strtok(NULL, ","));
            stock->data[0].low = atof(strtok(NULL, ","));
            stock->data[0].close = atof(strtok(NULL, ","));
            stock->data[0].volume = atoi(strtok(NULL, ","));
            stock->data[0].adjClose = atof(strtok(NULL, ","));
            stock->dataCount = 1; // Setze dataCount auf 1, da wir hier nur einen Datensatz haben
            break; // Diese Schleife bricht nach dem ersten Tagesdatensatz ab
        }
    }
    fclose(file);
    printf("Loaded succesfully!\n");
}


int main() {
    HashTable hashtable;
    memset(&hashtable, 0, sizeof(hashtable));

    int choice;
    do {
        printf("\nMenu:\n");
        printf("1. ADD\n");
        printf("2. DEL\n");
        printf("3. IMPORT\n");
        printf("4. SEARCH\n");
        printf("5. PLOT\n");
        printf("6. SAVE <filename>\n");
        printf("7. LOAD <filename>\n");
        printf("8. QUIT\n");

        printf("Enter your choice: ");
        scanf("%d", &choice);
        getchar(); // Consume newline character

        switch (choice) {
            case 1: {
                char name[50], wkn[20], symbol[20];
                printf("Enter stock name: ");
                fgets(name, sizeof(name), stdin);
                name[strcspn(name, "\n")] = '\0'; // Remove trailing newline character
                printf("Enter WKN: ");
                fgets(wkn, sizeof(wkn), stdin);
                wkn[strcspn(wkn, "\n")] = '\0'; // Remove trailing newline character
                printf("Enter symbol: ");
                fgets(symbol, sizeof(symbol), stdin);
                symbol[strcspn(symbol, "\n")] = '\0'; // Remove trailing newline character
                Stock* stock = create_stock(name, wkn, symbol);
                insert_stock(&hashtable, stock);
                printf("Stock added successfully.\n");
                break;
            }
            case 2: {
                char symbol[20];
                printf("Enter symbol of the stock to delete: ");
                scanf("%s", symbol);
                delete_stock(&hashtable, symbol);
                printf("\n");
                break;
            }
            case 3: {
                char filename[MAX_FILENAME_LENGTH];
                printf("Enter filename to import data: ");
                scanf("%s", filename);
                getchar(); // Consume newline character
                import_data_from_csv(&hashtable);
                printf("Data imported successfully.\n");
                break;
            }
          case 4: {
                char key[20];
                printf("Enter stock symbol to search: ");
                scanf("%s", key);
                Stock* stock = search_stock(&hashtable, key);
                if (stock != NULL) {
                    printf("Stock found: %s, %s, %s\n", stock->name, stock->wkn, stock->symbol);
                } else {
                    printf("Stock not found.\n");
                }
                break;
            }
            case 5: {
                char key[20];
                printf("Enter stock symbol to plot: ");
                scanf("%s", key);
                Stock* stock = search_stock(&hashtable, key);
                if (stock != NULL) {
                    display_plot(stock);
                } else {
                    printf("Stock not found.\n");
                }
                break;
            }
            case 6: {
                char filename[MAX_FILENAME_LENGTH];
                printf("Enter filename to save: ");
                scanf("%s", filename);
                save_hash_table(&hashtable, filename);
                break;
            }
            case 7: {
                char filename[MAX_FILENAME_LENGTH];
                printf("Enter filename to load: ");
                scanf("%s", filename);
                load_hash_table(&hashtable, filename);
                break;
            }
            case 8:
                printf("Exiting program.\n");
                exit(0);
            default:
                printf("Invalid choice. Please try again.\n");
        }
    } while (choice != 8);

    // Vor dem Programmende die Speicherbereinigung durchführen
    for (int i = 0; i < TABLE_SIZE; ++i) {
        if (hashtable.stocks[i] != NULL) {
            free(hashtable.stocks[i]);
            hashtable.stocks[i] = NULL;
        }
    }

    return 0;
}
