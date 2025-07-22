# Algorithms and Data Structures – C Programming Projects

This repository contains three major assignments completed as part of the *Algorithms and Data Structures* course, using the C programming language.  
Each project focuses on a different fundamental data structure or algorithmic paradigm, including hashing, trees, and graphs.

---

## Project 1: Stock Management System (Hash Table)

An interactive command-line program for managing and visualizing stock data using a custom-built hash table.

### Features:
- Insert, delete, and search stocks by name or ticker symbol
- Import historical data from CSV (e.g. Yahoo Finance)
- Store 30-day stock price history with `Date, Open, High, Low, Close, Volume, Adj Close`
- ASCII visualization of closing price trends
- Save/load full hash table via serialization
- Custom hash function with **quadratic probing** for collision resolution

---

## Project 2: AVL Tree Checker & Subtree Search

This program reads integer data from a file and builds a binary search tree, validating whether it fulfills AVL balancing rules.

### Features:
- AVL tree validation using recursive balance-factor checks
- Output of balance factors and AVL violations
- Display of tree statistics: min, max, average value
- Subtree matching and simple key search within the BST

---

## Project 3: Shortest Path in Public Transport Networks (Graph Algorithms)

A program that finds the shortest travel path in a weighted graph representing a transport network (e.g. Vienna's subway system).

### Features:
- Parse graph structure from plain-text format with stations and travel times
- Find the least-cost path between two stations using Dijkstra's algorithm
- Output includes:
  - full path with station names and used lines
  - transfers between lines
  - total travel cost
- File-agnostic structure: works with any network file in correct format

---

## Focus Areas Across All Projects

- Data structure implementation from scratch (no STL or libraries)
- Recursive algorithms (tree traversals, AVL checking, pathfinding)
- Algorithm analysis with Big-O complexity considerations
- Efficient memory and pointer handling in C
- Real-world data parsing and CLI interface building

---

> These projects provided deep hands-on experience with core data structures and algorithms, emphasizing both theoretical understanding and practical application in C.



