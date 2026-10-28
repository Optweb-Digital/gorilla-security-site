WordPress Docker Local Setup
============================

Purpose
-------
Run the project's WordPress environment locally and access it through a browser.

Before starting
---------------
- Docker Desktop is installed and running.
- The repository has been cloned to your computer.
- The repository root contains `compose.yaml`.
- The WordPress files required by the Compose configuration are present.

1. Clone with GitHub Desktop
----------------------------
1. Open GitHub Desktop and sign in.
2. Select File → Clone Repository.
3. Select the training repository.
4. Choose a local directory and click Clone.
5. Use Repository → Show in Explorer to open the local folder.

2. Open a terminal in the repository root
-----------------------------------------
Open PowerShell in the folder containing `compose.yaml`. Check the current folder and files:

    Get-Location
    Get-ChildItem -Force

3. Review Compose configuration
-------------------------------
Read the configuration:

    Get-Content .\compose.yaml

Check that it defines the required WordPress and database services and the port mapping. Do not publish real credentials. Prefer environment variables or a local `.env` excluded by `.gitignore`, and provide a safe `.env.example` with placeholders if needed.

4. Start the containers
-----------------------
Run:

    docker compose up -d

Check status:

    docker compose ps

View logs if needed:

    docker compose logs

The exact service names depend on `compose.yaml`.

5. Open the local site
----------------------
If `compose.yaml` maps host port 8080 to WordPress, open:

    http://localhost:8080

If it does not load, confirm Docker Desktop is running, check `docker compose ps` and `docker compose logs`, and verify the port mapping in `compose.yaml`.

6. Install WordPress if prompted
--------------------------------
If the WordPress setup screen appears, select a language and follow the installation wizard.

Use the database name, username, password, and host configured for this local Compose project. The database host is usually the database service name in `compose.yaml`, not `localhost`. Do not guess these values.

Choose a local site title and administrator account. Do not reuse production credentials.

If an existing site appears instead of the installer, WordPress may already be configured with a database volume.

7. Open the dashboard
---------------------
If the site uses port 8080, the dashboard is:

    http://localhost:8080/wp-admin

8. Stop and restart
-------------------
Stop containers:

    docker compose down

Start them again:

    docker compose up -d

`docker compose down` normally preserves named volumes. Do not use `docker compose down -v` unless you intentionally want to delete the named volumes and their data.

Database and site content
-------------------------
Git tracks files, not the contents of a Docker named database volume. Cloning the repository does not copy the database from another computer. If teammates need the same posts, pages, users, plugin settings, or media, arrange a safe database and uploads transfer. Never commit a database dump containing private or production data.
