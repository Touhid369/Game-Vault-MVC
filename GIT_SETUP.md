# Git Configuration Guide

## Problem: Commits Not Showing on GitHub

If your commits are not appearing on your GitHub profile, it's usually because the email address configured in Git doesn't match your GitHub account email.

## Solution

### 1. Check Your Current Git Configuration

```bash
git config user.name
git config user.email
```

### 2. Set the Correct Email Address

Make sure the email matches one of the email addresses associated with your GitHub account:

```bash
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
```

**Important:** The email must be:
- Correctly spelled (e.g., `gmail.com` not `gmai.com`)
- Associated with your GitHub account
- Verified in your GitHub account settings

### 3. Verify Your GitHub Email Addresses

1. Go to [GitHub Email Settings](https://github.com/settings/emails)
2. Check which email addresses are associated with your account
3. Make sure your Git email matches one of these

### 4. For This Repository

A `.mailmap` file has been added to correct historical commits with incorrect email addresses. This tells GitHub to attribute commits made with the wrong email to the correct account.

## Common Issues

1. **Typo in email domain** (e.g., `gmai.com` instead of `gmail.com`)
2. **Using personal email instead of GitHub-verified email**
3. **Email not verified in GitHub settings**
4. **Commits made with default Git installation without proper configuration**

## Prevention

Always configure Git before making your first commit:

```bash
git config --global user.name "Touhid369"
git config --global user.email "mtouhid33@gmail.com"
```

Check your configuration:

```bash
git config --list | grep user
```

## References

- [GitHub: Setting your commit email address](https://docs.github.com/en/account-and-profile/setting-up-and-managing-your-personal-account-on-github/managing-email-preferences/setting-your-commit-email-address)
- [GitHub: Why are my contributions not showing up on my profile?](https://docs.github.com/en/account-and-profile/setting-up-and-managing-your-github-profile/managing-contribution-graphs-on-your-profile/why-are-my-contributions-not-showing-up-on-my-profile)
