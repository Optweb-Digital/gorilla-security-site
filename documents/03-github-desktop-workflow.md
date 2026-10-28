GitHub Desktop Workflow
=======================

Clone a repository
------------------
1. Open GitHub Desktop and sign in.
2. Select File → Clone Repository.
3. Choose the repository and local path.
4. Click Clone.

Before editing, confirm the correct repository and branch are selected.

Commit changes
--------------
1. Edit or add a file in the local repository.
2. Return to GitHub Desktop.
3. Review changed files and diffs.
4. Make sure no secrets, passwords, private configuration, or database dumps are included.
5. Enter a summary such as `Add Docker setup documentation`.
6. Click Commit to main, or commit to your feature branch.

Push changes
------------
After committing, click Push origin to upload local commits to GitHub.

Fetch and pull
--------------
- Fetch origin checks the remote for updates.
- Pull origin downloads and integrates remote changes into the current branch.

If you edit a file directly on GitHub.com, open GitHub Desktop, click Fetch origin, then Pull origin if available.

Resolve authentication errors
-----------------------------
1. In GitHub Desktop, open File → Options → Accounts.
2. Confirm you are signed into the correct GitHub account.
3. Confirm the account has repository access.
4. Sign in again if necessary, then retry Push origin.

If a push fails because of a network connection reset, check the network and retry after connectivity is restored.

Review before pushing
---------------------
Avoid committing `.env` files with secrets, `wp-config.php` with credentials, private database dumps, API keys, or access tokens.

If a secret was already committed, deleting it in a later commit does not remove it from Git history. Treat it as exposed and rotate it.
