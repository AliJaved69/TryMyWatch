import './bootstrap';
import './components/GlareHover.css';

import React from 'react';
import { createRoot } from 'react-dom/client';
import Lightfall from './components/Lightfall';

document.addEventListener('DOMContentLoaded', () => {
    const lightfallHeroEl = document.getElementById('lightfall-hero');
    if (lightfallHeroEl) {
        const root = createRoot(lightfallHeroEl);
        root.render(
            <Lightfall
                colors={['#F1E5AC', '#F9F1D2', '#C5C6C7', '#FFFFFF', '#0F52BA']}
                backgroundColor="#06070a"
                speed={0.6}
                streakCount={6}
                streakWidth={1.2}
                streakLength={1.0}
                glow={1.3}
                density={0.7}
                twinkle={1.0}
                zoom={2.5}
                backgroundGlow={0.6}
                opacity={1.0}
                mouseInteraction={true}
                mouseStrength={0.8}
                mouseRadius={0.8}
            />
        );
    }

    const lightfallStoreEl = document.getElementById('lightfall-store');
    if (lightfallStoreEl) {
        const root = createRoot(lightfallStoreEl);
        root.render(
            <Lightfall
                colors={['#F1E5AC', '#F9F1D2', '#C5C6C7', '#FFFFFF', '#0F52BA']}
                backgroundColor="#06070a"
                speed={0.35}
                streakCount={4}
                streakWidth={1.0}
                streakLength={1.0}
                glow={1.1}
                density={0.4}
                twinkle={0.8}
                zoom={2.0}
                backgroundGlow={0.2}
                opacity={0.5}
                mouseInteraction={true}
                mouseStrength={0.5}
                mouseRadius={0.6}
            />
        );
    }
});
