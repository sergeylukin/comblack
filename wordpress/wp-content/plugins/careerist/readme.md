# Careerist

## Database

Creates following tables:

- areas
- categories
- jobs
- logs

## How it works

### Fetcher

Fetcher does following

- grabs external source driver
- grabs list of IDs of categories that are in table
- requests list of categories to get DIFF
- if there are more than 500 items in DIFF - fetches the full list and inserts in DB
- if there are less - runs over each ID and requests one by one and inserts in the DB

### Assigner

- if there is no term_id look for one in terms and assign
- for each area do the same ^^^
- for each synced category go over each job without post_id - insert into db with assigned term "autoposted_by": "careerist" and with "careerist_job_id"

### Dashboard

- logs (runs, decisions on earch group of items, )
