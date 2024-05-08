# Voting system

## Description

Final project for a course WEBTE-2 in FEI STU

## Table of Contents

- [Installation](#installation)

## Installation

### Prerequisites

- Docker installed on your machine.

### Steps

1. Clone the repository:
   ```sh
   git clone https://https://github.com/jdatsenko/webte2_final
   ```
2. Change directory to the project root:
   ```sh
   cd webte2_final
   ```
3. Compose the Docker container:
   ```sh
    docker compose up -d
   ```
4. Build the frontend:
   ```sh
    cd src/frontend
    npm install
    npm run build
   ```
5. Open the application in your browser:
   ```
   http://localhost
   ```

When changing the frontend code, you need to rebuild it:

```sh
cd src/frontend
npm run build
```
