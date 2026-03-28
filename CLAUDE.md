# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

"Our House" is a Laravel 12 family/household management app. Features: a social feed (Posts), a chore wheel (Tasks), a calendar (Events), and a gallery — all with polymorphic comments and likes.

## Commands

```bash
# Start full dev environment (PHP server + queue + logs + Vite)
composer dev

# Run tests
php artisan test
php artisan test --filter TestName   # single test

# Code linting
./vendor/bin/pint

# Frontend
npm run dev    # Vite dev server (HMR on port 5173)
npm run build  # Production build

# DB
php artisan migrate
php artisan migrate:fresh --seed
```

## Architecture

### Models & Relationships

All core content models (Post, Task, Event) share the same shape: they belong to a User, optionally have an Image, and use two traits:
- **Commentable** — polymorphic `morphMany` comments
- **Likeable** — polymorphic `morphMany` likes

**Task** is the exception: it has two user relationships (`user_id` = creator, `assignee_id` = assigned member) and a `TaskStatus` enum (`TODO`, `IN_PROGRESS`, `DONE`).

**User** and **Post** and **Event** use `GenerateUniqueSlugTrait` to auto-generate URL slugs (with collision handling: `slug-1`, `slug-2`).

**Comment** supports threading via a nullable `parent_id` self-referencing FK.

### Routing

Routes use implicit model binding on slugs: `{post:slug}`, `{user:slug}`, `{event:slug}`.

The "Wheel of Chores" (tasks) is at `/wheel` and handled by `TaskController` with actions: `wheelIndex`, `myTasks`, `store`, `update`, `updateStatus`, `assign`, `destroy`.

### Image Handling

`ImageService` handles uploads and stores files to `storage/app/public/images/{type}/` where type is one of: `profile`, `post`, `gallery`, `task`. Images can also be external URLs. The `Image` model is referenced by FK from User, Post, Task, Event.

### Frontend Stack

- **Tailwind CSS 4** — custom color palette defined in `resources/css/app.css` as CSS variables (`--color-primary`, `--color-secondary`, `--color-compliment`, `--color-dark-compliment`, `--color-main-dark`, `--color-main-light`)
- **Alpine.js 3** — reactive UI components (`x-data`, `x-show`, etc.)
- **Trix** — rich text editor for post/event content
- **AppModal** — global modal controller in `resources/js/app.js` with `.open()` / `.close()` API; used throughout views for confirmations and forms

### Sessions / Cache / Queue

All three are database-backed (tables: `sessions`, `cache`, `jobs`). No Redis required.
