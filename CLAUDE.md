# CLAUDE.md — suiinnova

## Frontend Design Guidelines

Create distinctive, production-grade frontend interfaces that avoid generic "AI slop" aesthetics. Every UI element must feel intentionally designed — bold, refined, and memorable.

### Design Thinking

Before coding any frontend, understand the context and commit to a BOLD aesthetic direction:
- **Purpose**: What problem does this interface solve? Who uses it?
- **Tone**: Pick a clear direction — brutally minimal, maximalist chaos, retro-futuristic, organic/natural, luxury/refined, playful/toy-like, editorial/magazine, brutalist/raw, art deco/geometric, soft/pastel, industrial/utilitarian, etc. Commit fully.
- **Constraints**: Technical requirements (framework, performance, accessibility).
- **Differentiation**: What makes this UNFORGETTABLE? What's the one thing someone will remember?

Choose a clear conceptual direction and execute it with precision. Bold maximalism and refined minimalism both work — the key is intentionality, not intensity.

### Aesthetics Rules

**Typography**: Choose fonts that are beautiful, unique, and interesting. Avoid generic fonts like Arial, Inter, and Roboto. Opt for distinctive, characterful choices. Pair a distinctive display font with a refined body font.

**Color & Theme**: Commit to a cohesive aesthetic. Use CSS variables for consistency. Dominant colors with sharp accents outperform timid, evenly-distributed palettes.

**Motion**: Use animations for effects and micro-interactions. Prioritize CSS-only solutions for HTML. Focus on high-impact moments: one well-orchestrated page load with staggered reveals (animation-delay) creates more delight than scattered micro-interactions. Use scroll-triggering and hover states that surprise.

**Spatial Composition**: Unexpected layouts. Asymmetry. Overlap. Diagonal flow. Grid-breaking elements. Generous negative space OR controlled density.

**Backgrounds & Visual Details**: Create atmosphere and depth rather than defaulting to solid colors. Add contextual effects and textures that match the overall aesthetic — gradient meshes, noise textures, geometric patterns, layered transparencies, dramatic shadows, decorative borders, and grain overlays.

### What to NEVER Do

- Generic AI aesthetics (purple gradients on white, cookie-cutter layouts)
- Overused font families (Inter, Roboto, Arial, system fonts)
- Cliched color schemes without context-specific character
- Predictable layouts and component patterns
- Converging on commonly overused fonts (e.g. Space Grotesk) across generations
- Animations without purpose

### Creative Ambition

Match implementation complexity to the aesthetic vision. Maximalist designs need elaborate code with extensive animations and effects. Minimalist or refined designs need restraint, precision, and careful attention to spacing, typography, and subtle details. Elegance comes from executing the vision well.

No two designs should look the same. Vary between light and dark themes, different fonts, different aesthetics. Interpret creatively and make unexpected choices that feel genuinely designed for the context.
