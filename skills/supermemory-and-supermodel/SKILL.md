---
name: supermemory-and-supermodel
description: Enforces persistent project-state tracking, database schema logging, and design decision memory to maintain strict context consistency across agent sessions.
---

# SuperMemory & SuperModel Skill

## Overview
This skill acts as the agent's long-term memory. It maintains a centralized `project_memory.md` file in the root of the project to record structural updates, database schema changes, configuration choices, API integrations, and current task lists. This prevents context loss when agent sessions are restarted.

## Workflow & Guidelines

### 1. Maintain the Memory File
- Always check for the existence of `project_memory.md` in the project root.
- If it does not exist, initialize it with the following structure:
  ```markdown
  # Project Memory: JAFAPP

  ## System Configuration
  - PHP Version:
  - Laravel Version:
  - Database:
  - Third-Party APIs:

  ## Database Schema (Current Status)
  - Tables implemented:
  - Structural changes made:

  ## Design & Theme Decisions
  - Color Tokens:
  - Typography:
  - Component conventions:

  ## API Integrations
  - Midtrans configuration status:

  ## Development Log
  - [Date] - Action: Description
  ```

### 2. Update After Every Turn
- At the completion of any major file modification, database migration, or setup step, immediately update the corresponding section in `project_memory.md`.
- Log the change in the **Development Log** section with a timestamp and description of what was done and why.

### 3. Read Memory First
- At the start of any new session or task, read `project_memory.md` to instantly synchronize with the current state of the database, configuration, and recent development history.

## Common Mistakes
- **Forgetting to update the log**: Failing to document schema changes makes subsequent agents write incorrect migrations.
- **Putting temporary notes in memory**: Keep memory concise and focused on permanent architectural decisions, configuration states, and logs.
