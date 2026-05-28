---
name: uiuxpromax
description: Rules and guidelines for creating premium, high-fidelity, and responsive UI/UX designs. It enforces harmonious color palettes, modern typography, loading states, and clean CSS/Tailwind component layout guidelines.
---

# UIUXProMax Design Skill

## Overview
This skill guides the design and implementation of the user interface for JAFAPP. It enforces a high-quality, professional aesthetic (brown/wood theme), typography, layout consistency, and interactive feedback.

## Design Tokens

### 1. Color Palette (JAFAPP Custom Theme)
Always implement the following HSL-mapped or hex colors:
- **Primary Brown**: `#6B3A2A` (CTA buttons, principal headings, primary accents)
- **Light Brown**: `#A0522D` (Hover states, secondary buttons, subtle alerts)
- **Cream / Warm Sand**: `#F5F0E8` (Main layout background, container cards)
- **Off-White**: `#FAFAF7` (Card backgrounds, form inputs, navigation bar)
- **Forest Green**: `#2D4A3E` (Successful actions, paid invoices, "Selesai" status badges)
- **Slate Text**: `#1A1A1A` (Primary body text)
- **Muted Gray**: `#6B7280` (Labels, captions, disabled states)
- **Divider**: `#E5E0D8` (Thin borders, table lines)

### 2. Typography
- **Headings (H1, H2, H3, H4)**: Use `Playfair Display` (serif, weight 600-700) to convey premium craftsmanship and woodwork.
- **Body & Forms**: Use `Inter` (sans-serif, weight 400-600) for high legibility on all devices.

## UI/UX Guidelines

### 1. Responsive & Mobile-First
- Design layouts starting from **375px width** up to desktop. Use Tailwind's grid systems: `grid-cols-1 md:grid-cols-2 lg:grid-cols-3`.
- Make sure tables wrap properly or have horizontal overflow scroll containers on mobile: `overflow-x-auto`.

### 2. Micro-Animations & Interactivity
- Apply transitions to all buttons, links, and cards: `transition duration-300 ease-in-out hover:scale-[1.01]`.
- Add hover scaling or opacity shifts for catalogs.

### 3. State-Based Visual Cues & Loading States
- Never leave pages frozen during asynchronous actions (like generating Midtrans Snap tokens or submitting custom orders).
- Display a sleek spinner, skeleton loading screens, or disabled submit states with loading spinners.
- Example Tailwind loading spinner class:
  ```html
  <svg class="animate-spin h-5 w-5 mr-3 text-white" viewBox="0 0 24 24">...</svg>
  ```

### 4. High-Quality Components
- **Production Timeline Stepper**: A vertical or horizontal progress stepper with green checkmarks for completed stages, loading animations for the active stage, and muted gray for remaining stages.
- **Product Cards**: Glassmorphism or subtle shadows (`shadow-sm hover:shadow-md`) with clear badges showing product status.

## Common Mistakes
- **Using browser default colors**: Plain `#FF0000` or `#0000FF` is unacceptable. Use tailored color palettes.
- **Static interfaces**: Not having hover states or loading feedback makes the web app feel unpolished.
- **Poor mobile layout**: Assuming elements will fit without defining proper flex or grid mobile layouts.
