# 📤 How to Upload EatOut to GitHub

## Option 1: Upload to New Repository

### Step 1: Create a new repository on GitHub
1. Go to https://github.com/new
2. Repository name: `eatout-restaurant-management` (or your choice)
3. Description: "Restaurant reservation and management system built with Symfony"
4. Choose Public or Private
5. **DO NOT** initialize with README (we already have one)
6. Click "Create repository"

### Step 2: Add all files to Git
```bash
git add .
```

### Step 3: Commit your changes
```bash
git commit -m "Initial commit: EatOut restaurant management system with full features"
```

### Step 4: Add GitHub remote (replace YOUR_USERNAME with your GitHub username)
```bash
git remote add origin https://github.com/YOUR_USERNAME/eatout-restaurant-management.git
```

### Step 5: Push to GitHub
```bash
# Push dev branch (current branch)
git push -u origin dev

# Push main branch
git checkout main
git merge dev
git push -u origin main

# Go back to dev
git checkout dev
```

## Option 2: If Remote Already Exists

### Check current remote
```bash
git remote -v
```

### If you need to change the remote URL
```bash
git remote set-url origin https://github.com/YOUR_USERNAME/your-repo-name.git
```

### Then push
```bash
git add .
git commit -m "Update: Complete EatOut system with all features"
git push origin dev
git push origin main
```

## 🔒 Important: Before Pushing

### 1. Check .env file is NOT committed
```bash
git status
```
Make sure `.env` shows as "modified" but NOT staged (it should be in .gitignore)

### 2. Create .env.example for others
```bash
cp .env .env.example
```
Then edit `.env.example` and remove sensitive data:
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```

### 3. Add .env.example to git
```bash
git add .env.example
git commit -m "Add environment example file"
```

## 📝 Recommended Commit Message Format

```bash
git commit -m "feat: Add reservation status workflow"
git commit -m "fix: Resolve image upload issue"
git commit -m "docs: Update README with installation steps"
git commit -m "style: Implement EatOut branding"
```

## 🌿 Branch Strategy

- **main** - Production-ready code
- **dev** - Development branch (current work)
- **feature/*** - New features (create as needed)

### Create a new feature branch
```bash
git checkout -b feature/new-feature-name
# Make changes
git add .
git commit -m "feat: Add new feature"
git push origin feature/new-feature-name
```

## 🔄 Keep Your Repository Updated

### Pull latest changes
```bash
git pull origin dev
```

### Merge dev into main
```bash
git checkout main
git merge dev
git push origin main
git checkout dev
```

## 📊 View Your Repository

After pushing, visit:
```
https://github.com/YOUR_USERNAME/eatout-restaurant-management
```

## 🎉 Done!

Your EatOut project is now on GitHub! 🚀

### Next Steps:
1. Add topics/tags to your repo (symfony, php, restaurant, reservation-system)
2. Add a license file
3. Enable GitHub Pages for documentation (optional)
4. Set up GitHub Actions for CI/CD (optional)
