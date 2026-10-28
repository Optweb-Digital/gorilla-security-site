Five Git Concepts: Practical Notes
==================================

1. Commit
---------
A commit records a snapshot of staged changes in the local repository.

    git status
    git add documents/
    git commit -m "Add Git training notes"

Use a short message that describes the change.

2. Push and pull
----------------
Push sends local commits to the remote repository:

    git push origin main

Pull fetches and integrates changes from the remote branch:

    git pull origin main

Make sure you are on the intended branch.

3. Pull requests
----------------
A pull request proposes changes from one branch to another for review.

1. Create a feature branch.
2. Make and commit changes.
3. Push the branch.
4. Open GitHub and create a pull request into `main`.
5. Ask a teammate to review.
6. Address feedback.
7. Merge after approval.

4. Conflict management
----------------------
A conflict can occur when Git cannot automatically combine changes, often because branches edited the same lines.

Safe practice exercise:
1. Create a test branch.
2. Edit the same line in a test document on two branches.
3. Commit each change.
4. Merge one branch into the other.
5. Review markers: `<<<<<<<`, `=======`, and `>>>>>>>`.
6. Edit the file to keep the intended content and remove the markers.
7. Stage and commit the resolved file.

Use a disposable test file, not credentials or important WordPress configuration.

5. Branching strategy
---------------------
Use `main` for the stable shared version and feature branches for individual tasks.

    git switch main
    git pull origin main
    git switch -c feature/docker-documentation

After editing and committing:

    git push -u origin feature/docker-documentation

Open a pull request and merge it after review. Then update local `main`:

    git switch main
    git pull origin main

Agree on descriptive branch names, focused changes, reviews before merging, and whether direct commits to `main` are allowed.
