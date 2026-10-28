Windows Prerequisites and Installation
=======================================

Purpose
-------
Install the applications required to run the WordPress Docker project and manage its source code.

1. Install Docker Desktop
-------------------------
1. Open https://www.docker.com/products/docker-desktop/.
2. Download Docker Desktop for Windows.
3. Run the installer and follow the prompts.
4. If prompted to use WSL 2, enable/install the required WSL components.
5. Restart Windows if requested.
6. Open Docker Desktop and wait until it reports that Docker is running.

Verify Docker in PowerShell:

    docker --version
    docker compose version
    docker info

The first two commands should print version information. `docker info` should show server information when Docker Desktop is running.

If Docker commands fail, confirm Docker Desktop is running and that WSL 2 and required virtualization features are enabled.

2. Install GitHub Desktop
-------------------------
1. Open https://desktop.github.com/.
2. Download and install GitHub Desktop.
3. Open it and sign in to the GitHub account that has access to the training repository.

3. Install Git (optional if already available)
----------------------------------------------
1. Open https://git-scm.com/downloads.
2. Download Git for Windows and run the installer.
3. Open a new PowerShell window and verify:

    git --version

4. Check repository access
--------------------------
The repository owner must invite you if the repository is private. Accept the invitation using the GitHub account you signed into.

Security
--------
Never put GitHub passwords, personal access tokens, API keys, database passwords, or production credentials in documentation or source control.
