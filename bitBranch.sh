#!/bin/sh

#git branch --no-color

current_branch=$(git branch -a --merged master 2>  /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/\1/')
if [ "$current_branch" != "master" ]; then
  echo "WARNING: You are on branch $current_branch, NOT master."
fi
echo "Fetching merged branches..."
git remote prune origin
remote_branches=$(git branch -r --merged | grep -v '/master$' | grep -v "/$current_branch$")
local_branches=$(git branch --merged | grep -v 'master$' | grep -v "$current_branch$")
if [ -z "$remote_branches" ] && [ -z "$local_branches" ]; then
  echo "No existing branches have been merged into $current_branch."
else
  echo "This will remove the following branches:"
  if [ -n "$remote_branches" ]; then
    echo "$remote_branches"
  fi
  if [ -n "$local_branches" ]; then
    echo "$local_branches"
  fi
  echo "###################"
  echo "Development and ui_changes will not be deleted"
  read -p "Continue? (y/n): " -n 1 choice
  echo
  if [ "$choice" == "y" ] || [ "$choice" == "Y" ]; then
    # Remove remote branches
    git push origin `git branch -r --merged | grep -v '/master$' | grep -v "/$current_branch$" | grep -v "Development" |grep -v "ui_changes"|sed 's/origin\//:/g' | tr -d '\n'`
    # Remove local branches
    git branch -d `git branch --merged | grep -v 'master$' |grep -v "Development" |grep -v "ui_changes"| grep -v "$current_branch$" | sed 's/origin\///g' | tr -d '\n'`
  else
    echo "No branches removed."
  fi
fi
