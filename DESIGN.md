---
name: "Pacudan's Bakeshop & Coffee Bar"
description: "Camiguin Botanical Tile & Roast Bar — volcanic-jade tilework, sun-washed plaster, and calamansi-amber ordering triggers."
colors:
  jade-deep: "#143B31"
  jade-raised: "#1E4F42"
  jade-hover: "#0E2B23"
  jade-tint: "#CBE0D8"
  amber-cta: "#D97706"
  amber-hover: "#B45309"
  amber-light: "#FCD34D"
  plaster-bg: "#F6F2E9"
  stone-soft: "#ECE6D9"
  card-bg: "#FFFFFF"
  ink-main: "#1D1815"
  ink-muted: "#4E4942"
typography:
  display:
    fontFamily: "Bricolage Grotesque, sans-serif"
    fontSize: "clamp(2rem, 4.1vw, 3.6rem)"
    fontWeight: 800
    lineHeight: 1.03
    letterSpacing: "-0.03em"
  headline:
    fontFamily: "Bricolage Grotesque, sans-serif"
    fontSize: "1.75rem"
    fontWeight: 800
    lineHeight: 1.15
    letterSpacing: "-0.025em"
  title:
    fontFamily: "Bricolage Grotesque, sans-serif"
    fontSize: "1.25rem"
    fontWeight: 700
    lineHeight: 1.25
    letterSpacing: "-0.02em"
  body:
    fontFamily: "Hanken Grotesk, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.6
    letterSpacing: "0em"
  label:
    fontFamily: "Hanken Grotesk, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "0.02em"
rounded:
  input: "12px"
  subtle: "14px"
  card: "18px"
  pill: "999px"
spacing:
  xs: "8px"
  sm: "12px"
  md: "16px"
  lg: "24px"
  xl: "40px"
components:
  button-primary:
    backgroundColor: "{colors.jade-deep}"
    textColor: "{colors.plaster-bg}"
    rounded: "{rounded.pill}"
    padding: "11px 26px"
  button-primary-hover:
    backgroundColor: "{colors.jade-hover}"
    textColor: "{colors.card-bg}"
  button-amber:
    backgroundColor: "{colors.amber-cta}"
    textColor: "{colors.ink-main}"
    rounded: "{rounded.pill}"
    padding: "12px 28px"
  button-outline:
    backgroundColor: "transparent"
    textColor: "{colors.jade-deep}"
    rounded: "{rounded.pill}"
    padding: "10px 24px"
  card-counter:
    backgroundColor: "{colors.card-bg}"
    textColor: "{colors.ink-main}"
    rounded: "{rounded.card}"
    padding: "16px"
  nav-bar:
    backgroundColor: "{colors.jade-deep}"
    textColor: "{colors.jade-tint}"
    padding: "12px 0"
---

# Design System: Pacudan's Bakeshop & Coffee Bar

## Overview

**Creative North Star: "Camiguin Botanical Tile & Roast Bar"**

This design system translates the warmth of a Mambajao neighborhood bakeshop and espresso bar into a disciplined architectural grammar. Deep volcanic-jade glazed tilework frames the storefront's navigation, opening masthead, and footer, anchored by a bold calamansi-amber sill that separates dark architectural surfaces from sun-washed plaster ordering shelves below.

Rather than retreating into generic cream-and-brown café templates or passive full-bleed banner imagery, the system leads immediately with real product photography, transparent Peso pricing, and working ordering controls. The same token hierarchy scales seamlessly from appetite-driven storefront surfaces (Home, Menu, Product Detail) into calm, tabular operational surfaces (Cart, Checkout, Profile, and the Admin Panel).

**Key Characteristics:**
- Deep volcanic-jade architectural chrome (`#143B31`) textured with subtle `64px` glazed tile hairlines
- Signature `6px` calamansi-amber architectural sill (`#D97706`) separating jade framing from plaster grounds
- Sun-washed plaster (`#F6F2E9`) and warm stone (`#ECE6D9`) ordering grounds with crisp white bordered cards
- Expressive `Bricolage Grotesque` display headings paired with legible `Hanken Grotesk` UI copy and tabular numerals
- Real product photography leading every card, with zero fabricated testimonials and zero eyebrow labels above headings

## Colors

The palette pairs deep volcanic-jade architectural surfaces with sunlit Camiguin plaster grounds and high-contrast calamansi-amber conversion accents.

### Primary
- **Volcanic Jade** (`jade-deep` / `#143B31`): Primary brand ground for the site navbar, Home masthead, footer, active category pills, and primary storefront/admin buttons.
- **Glazed Jade Tile** (`jade-raised` / `#1E4F42`): Elevated tile surface used for the masthead Signature Bake showcase and mobile collapsed navigation drawer.
- **Deep Canopy Hover** (`jade-hover` / `#0E2B23`): Interactive hover and active fill for primary volcanic-jade buttons.

### Secondary
- **Calamansi Amber** (`amber-cta` / `#D97706`): Signature `6px` architectural sill, navbar Order Bag pill, direct checkout CTAs, and primary masthead action button (paired with dark charcoal ink for WCAG AAA readability).
- **Toasted Amber** (`amber-hover` / `#B45309`): Secondary warm accent used for inline category metadata labels below product descriptions on light plaster surfaces.
- **Sunlit Gold** (`amber-light` / `#FCD34D`): High-contrast Peso price and counter-hours highlight strictly on dark volcanic-jade surfaces.

### Neutral
- **Sun-Washed Plaster** (`plaster-bg` / `#F6F2E9`): Global page ground across customer storefront and Admin Panel.
- **Warm Stone** (`stone-soft` / `#ECE6D9`): Form field fills, summary sub-panels, admin sub-navigation tracks, and "Our Story" panel ground.
- **Plaster White** (`card-bg` / `#FFFFFF`): Product counter cards, checkout panels, order tables, and modal surfaces.
- **Espresso Charcoal** (`ink-main` / `#1D1815`): Primary text ink on plaster, stone, white, and calamansi-amber buttons.
- **Muted Basalt** (`ink-muted` / `#4E4942`): Secondary descriptions, timestamps, and table headers on light surfaces.
- **Sea-Glass Tint** (`jade-tint` / `#CBE0D8`): Secondary prose and navigation links on volcanic-jade surfaces (never gray).

### Named Rules
**The Jade-to-Plaster Sill Rule.** Every transition between a dark volcanic-jade structural band (navbar, Home masthead, footer) and a sun-washed plaster field is marked by a single `6px` calamansi-amber sill (`#D97706`). On unscrolled Home, the navbar drops its sill so navbar and masthead read as one continuous tiled facade.

**The No-Gray-On-Jade Rule.** Secondary copy on `#143B31` or `#1E4F42` surfaces always uses sea-glass tint (`#CBE0D8`) or sunlit gold (`#FCD34D`), never muted neutral gray.

## Typography

**Display Font:** Bricolage Grotesque (`sans-serif` fallback)
**Body Font:** Hanken Grotesk (`sans-serif` fallback)

**Character:** `Bricolage Grotesque` brings warm, slightly quirky architectural geometry to headings and menu titles without falling into generic serif café clichés, while `Hanken Grotesk` keeps descriptions, checkout forms, and admin tables crisp and compact.

### Hierarchy
- **Display** (`800`, `clamp(2rem, 4.1vw, 3.6rem)`, line-height `1.03`, tracking `-0.03em`): Home masthead headline and primary landing hooks.
- **Headline** (`800`, `1.75rem–2.25rem`, line-height `1.15`, tracking `-0.025em`): Page titles (`Our Menu`, `Admin Dashboard`, `Your Order Bag`) and section headers.
- **Title** (`700`, `1.15rem–1.25rem`, line-height `1.25`): Product card titles, summary panels, and modal headers.
- **Body** (`400–500`, `1rem`, line-height `1.6`, max measure `68ch`): Product descriptions, café story copy, and delivery notes.
- **Label** (`700`, `0.85rem–0.9rem`, line-height `1.2`): Navigation links, category pills, form field labels, and action buttons.

### Named Rules
**The Tabular Peso Rule.** Every Philippine Peso price (`₱`), bag counter, stock count, order ID, and dashboard metric enforces `font-variant-numeric: tabular-nums` so prices align cleanly across product rows and order tables.

**The Heading-First Rule.** Never place an uppercase kicker or category eyebrow above a heading (`h1`–`h5`). Product titles lead directly below photography; category labels sit beneath the description.

## Layout

The layout uses Bootstrap 5's responsive 12-column container grid over a continuous sun-washed plaster canvas (`#F6F2E9`), switching cleanly between a full-bleed volcanic-jade masthead on Home and `96px` top clearance beneath the fixed navbar on inner pages.

- **Desktop First Viewport (`1440×900`):** Seamless volcanic-jade navbar + asymmetric `7/5` masthead (headline + CTAs left, glazed Signature Bake tile right) separated by the `6px` amber sill from the plaster counter shelf holding the category pill strip and all four Today's Counter Picks cards with visible prices and `+ Add` actions above the fold.
- **Menu & Storefront Grids:** 4 columns on large desktop (`lg`), 3 on medium (`md`), 2 on small tablets (`sm`), 1 on narrow mobile, with `16px–24px` gutters (`g-3` / `g-4`).
- **Mobile Category Strip (`< 992px`):** Horizontal scrollable pill row wrapped in `.cat-strip-wrap` with a `44px` right-edge plaster fade mask so overflowing pills dissolve smoothly rather than hard-clipping mid-word.
- **Admin Operate Layout:** Shared pill `.admin-subnav` (`Dashboard`, `Orders`, `Inventory`, `Add Product`) anchored above every admin screen for 1-click navigation between workflows.

## Elevation & Depth

Surfaces rely primarily on tonal contrast (volcanic jade → sun-washed plaster → warm stone → crisp white) and crisp `1px` jade-tinted hairline borders (`rgba(20, 59, 49, 0.15)`) rather than heavy drop shadows. Shadows stay soft, offset, and tinted with volcanic jade.

### Shadow Vocabulary
- **Card Rest** (`box-shadow: 0 6px 20px rgba(20, 59, 49, 0.05)`): Subtle lift for product counter cards on plaster ground.
- **Panel Lift** (`box-shadow: 0 10px 28px rgba(20, 59, 49, 0.06)`): Checkout summaries, order tables, and auth panels.
- **Glazed Tile Depth** (`box-shadow: 0 18px 38px rgba(8, 25, 20, 0.28)`): Masthead Signature Bake tile sitting on deep volcanic jade.
- **Focus Ring** (`outline: 2px solid #D97706; outline-offset: 2px`): High-visibility keyboard focus indicator across all links, buttons, and inputs.

### Named Rules
**The Quiet-At-Rest Rule.** Cards sit framed by `1px` jade-tinted borders and light ambient lift; motion is concentrated in a single authored exponential ease-out (`cubic-bezier(0.16, 1, 0.3, 1)`) settle on the masthead Signature Bake tile and subtle thumbnail zoom (`scale(1.04)`) on pointer hover, honoring `prefers-reduced-motion`.

## Shapes

The system pairs structured architectural rectangles (`18px` card radius, `12px` inner photo and input radius) with tactile pill-shaped interactive controls (`999px` radius on buttons, category filters, bag counter, and admin sub-navigation). No organic CSS clip-paths or decorative blobs are used; food photographs stay in clean `4:3` or `1:1` frames.

## Components

### Buttons
- **Shape:** Full pill (`999px` radius).
- **Primary (`btn-primary`):** Volcanic-jade fill (`#143B31`) with plaster text (`#F6F2E9`), `11px 26px` padding, shifting to `#0E2B23` with subtle `-1px` lift on hover.
- **Conversion Accent (`btn-amber`):** Calamansi-amber fill (`#D97706`) with charcoal ink (`#1D1815`), reserved for the navbar Bag pill, primary masthead browse CTA, Order Direct, and Checkout confirmation.
- **Secondary (`btn-outline-primary`):** `1.5px` volcanic-jade outline filling solid `#143B31` on hover/active; on dark jade surfaces, `btn-ghost-jade` uses a translucent sea-glass border (`rgba(203, 224, 216, 0.55)`).

### Category Filter Chips
- **Style:** Pill-shaped (`999px`) controls with `1.5px` volcanic-jade border on plaster ground.
- **State:** Active category fills solid `#143B31` with `#F6F2E9` text; inactive pills stay outlined and fill on hover.

### Counter Product Cards
- **Corner Style:** `18px` outer card radius with `12px` inner photo frame.
- **Background & Border:** Crisp white (`#FFFFFF`) with `1px solid rgba(20, 59, 49, 0.15)`.
- **Behavior:** Real product photo and title link directly to the Product Detail page; Peso price and AJAX `+ Add` / `Add to Bag` buttons remain permanently visible for mobile, touch, and keyboard users (never hidden behind hover-only overlays).

### Inputs & Steppers
- **Style:** Warm stone fill (`#ECE6D9`), borderless resting state, `999px` pill radius for single-line inputs and `14px` radius for textareas, with `#D97706` caret and focus ring.
- **Cart Quantity Steppers:** Rounded `+/-` buttons flanking a centered tabular number input that auto-syncs cart quantities.

### Navigation
- **Desktop & Mobile:** Fixed volcanic-jade bar (`#143B31`) with circular `pacudans_logo.jpg`, active rounded pill highlight (`rgba(246, 242, 233, 0.1)`), live notification bell + favorites counter for signed-in users, and a persistent calamansi-amber `Bag (N)` pill visible on both desktop and mobile headers.

### Signature Glazed Tile
- Elevated `#1E4F42` container inside the Home masthead showcasing a live celebration cake from the catalog with its square photo, description, `#FCD34D` Peso price, and direct order button.

## Do's and Don'ts

### Do:
- **Do** keep real product photography uncrowded with zero text or price badges pasted over the center of food photos.
- **Do** use `tabular-nums` on every Peso amount, quantity stepper, order ID, and admin revenue table.
- **Do** keep primary ordering actions (`+ Add`, `Add to Bag`, `Order Now`) permanently visible across desktop, touch, and keyboard sessions.
- **Do** carry the exact volcanic-jade (`#143B31`) and calamansi-amber (`#D97706`) palette into Chart.js dashboards and admin sub-navigation.
- **Do** theme browser surfaces (`::selection`, scrollbars, `caret-color`, `:focus-visible`) from the palette.

### Don't:
- **Don't** add eyebrow or kicker labels above headings on hero sections, page headers, or product cards.
- **Don't** invent customer testimonials, star ratings, or unverified marketing claims; surface verified shop hours, Mambajao COD terms, and live catalog data instead.
- **Don't** use generic gray text on volcanic-jade surfaces—always tint secondary text with `#CBE0D8`.
- **Don't** nest `.card` containers inside other `.card` containers or use watermarked promotional banners where clean photography belongs.
- **Don't** hide category navigation behind a duplicate hamburger icon or hide product actions behind hover-only overlays.
