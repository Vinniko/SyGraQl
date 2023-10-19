## SyGraQL (Symfony PHP framework + GraphQL test application)

## Installation

Copy .env from .env.example file and then write your database config

```bash
cp .env.example .env
```
Run composer install

```bash
composer install
```

Run migrations

```bash
php bin/console doctrine:migrations:migrate
```

Run seeders

```bash
php bin/console doctrine:fixtures:load
```

Run:

```bash
symfony serv
```
Enter in browser:

```bash 
localhost:8000
```

Examples of requests:

Update Tag:

```graphql
mutation UpdateTag {
    updateTag(tag: {id: 33, name: "Test", color: "black" , score: 333, type: FIRST}){
        id,
        name,
        color,
        score,
        type
    }
}
```

GetStat:

```graphql
query GetStat {
    getstat(start_date: "2023-10-17 00:00:00", end_date: "2023-10-23 00:00:00", type: FIRST){
        complexityIndex,
        standardDeviation,
        averageValue
    }
}
```




