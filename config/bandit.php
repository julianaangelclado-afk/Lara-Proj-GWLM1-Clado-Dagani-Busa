<?php

/*
|--------------------------------------------------------------------------
| Bandit Music Studio - content data
|--------------------------------------------------------------------------
| Edit names, prices and descriptions here. The pages read from this file.
| To use a REAL PHOTO instead of the included illustration:
|   1. Put your photo in public/images/ (example: public/images/studios/rock.jpg)
|   2. Change the 'image' value below to 'images/studios/rock.jpg'
*/

return [

    'studios' => [
        'rock' => [
            'name'     => 'Rock Studio',
            'tagline'  => 'Loud, raw and electric.',
            'desc'     => 'Brick walls, neon bolts and a full amp wall. Built for riffs that shake the floor.',
            'image'    => 'images/studios/rock.png',
            'rate'     => 450,
            'capacity' => 6,
            'features' => ['Amp wall', 'Neon stage lights', 'Drum riser'],
        ],
        'jazz' => [
            'name'     => 'Jazz Studio',
            'tagline'  => 'Warm, smooth and intimate.',
            'desc'     => 'Velvet curtains, soft lamps and a cozy stage for horns, keys and upright bass.',
            'image'    => 'images/studios/jazz.png',
            'rate'     => 400,
            'capacity' => 6,
            'features' => ['Warm lamps', 'Velvet curtains', 'Piano corner'],
        ],
        'opm' => [
            'name'     => 'OPM Studio',
            'tagline'  => 'Proudly Pinoy sound.',
            'desc'     => 'Inspired by Filipino colors and banig weaves. Perfect for acoustic and original Pinoy music.',
            'image'    => 'images/studios/opm.png',
            'rate'     => 350,
            'capacity' => 5,
            'features' => ['Acoustic friendly', 'Banig-style decor', 'Cozy vocals booth'],
        ],
        'rnb' => [
            'name'     => 'R&B Studio',
            'tagline'  => 'Smooth, neon and soulful.',
            'desc'     => 'Neon rings, vinyl vibes and a vintage mic. Made for harmonies and late-night grooves.',
            'image'    => 'images/studios/rnb.png',
            'rate'     => 400,
            'capacity' => 5,
            'features' => ['Vintage mic', 'Neon mood lights', 'Vocal booth'],
        ],
        'reggae' => [
            'name'     => 'Reggae Studio',
            'tagline'  => 'Sunset, sea and heavy bass.',
            'desc'     => 'Island sunset colors and a bass-friendly room. Relax, rehearse and ride the groove.',
            'image'    => 'images/studios/reggae.png',
            'rate'     => 350,
            'capacity' => 6,
            'features' => ['Bass-ready room', 'Island decor', 'Chill lounge'],
        ],
    ],

    'categories' => [
        ['key' => 'electric-guitar', 'label' => 'Electric Guitar', 'emoji' => '🎸'],
        ['key' => 'acoustic-guitar', 'label' => 'Acoustic Guitar', 'emoji' => '🪕'],
        ['key' => 'bass',            'label' => 'Bass Guitar',     'emoji' => '🎸'],
        ['key' => 'drums',           'label' => 'Drums',           'emoji' => '🥁'],
        ['key' => 'keyboard',        'label' => 'Keyboard',        'emoji' => '🎹'],
        ['key' => 'pedals',          'label' => 'Pedals & Gear',   'emoji' => '🎛️'],
    ],

    // 'rate' = rental price per hour (PHP). Change to your real prices.
    'instruments' => [
        // Electric guitars (3)
        ['id' => 'eg-strat',   'category' => 'electric-guitar', 'name' => 'Stratocaster-Style Electric', 'brand' => 'Fender Stratocaster',
         'desc' => 'Bright, glassy tone with three single-coil pickups. Great for funk, pop and clean leads.', 'image' => 'images/instruments/eg-strat.webp', 'rate' => 100],
        ['id' => 'eg-lespaul', 'category' => 'electric-guitar', 'name' => 'Les Paul Electric',            'brand' => 'Gibson Les Paul',
         'desc' => 'Thick, warm humbucker sound. A rock and blues classic.', 'image' => 'images/instruments/eg-lespaul.webp', 'rate' => 120],
        ['id' => 'eg-v',       'category' => 'electric-guitar', 'name' => 'Flying V Electric',            'brand' => 'Gibson Flying V',
         'desc' => 'Sharp look and aggressive tone for hard rock and metal.', 'image' => 'images/instruments/eg-v.webp', 'rate' => 110],

        // Acoustic guitars (3 brands)
        ['id' => 'ac-yamaha',  'category' => 'acoustic-guitar', 'name' => 'Yamaha FG800',  'brand' => 'Yamaha',
         'desc' => 'Solid spruce top with a balanced, full sound. Easy to play.', 'image' => 'images/instruments/ac-yamaha.webp', 'rate' => 80],
        ['id' => 'ac-taylor',  'category' => 'acoustic-guitar', 'name' => 'Taylor GS Mini', 'brand' => 'Taylor',
         'desc' => 'Compact body with a big voice. Comfortable for long jams.', 'image' => 'images/instruments/ac-taylor.webp', 'rate' => 100],
        ['id' => 'ac-cort',    'category' => 'acoustic-guitar', 'name' => 'Cort AD810',    'brand' => 'Cort',
         'desc' => 'Dark mahogany look with a warm tone. Budget friendly.', 'image' => 'images/instruments/ac-cort.webp', 'rate' => 70],

        // Bass guitars (3)
        ['id' => 'bs-p',  'category' => 'bass', 'name' => 'Precision Bass',    'brand' => 'Fender Precision',
         'desc' => 'Deep, punchy low end. The standard sound for rock and pop.', 'image' => 'images/instruments/bs-p.png', 'rate' => 100],
        ['id' => 'bs-sr', 'category' => 'bass', 'name' => 'SR Series Bass',    'brand' => 'Ibanez SR',
         'desc' => 'Slim neck and fast feel. Great for tight grooves and slap.', 'image' => 'images/instruments/bs-sr.png', 'rate' => 110],
        ['id' => 'bs-bb', 'category' => 'bass', 'name' => 'BB Series Bass',    'brand' => 'Yamaha BB',
         'desc' => 'Powerful and punchy with a thick tone. Loved for reggae and R&B.', 'image' => 'images/instruments/bs-bb.webp', 'rate' => 100],

        // Drums (2)
        ['id' => 'dr-electric', 'category' => 'drums', 'name' => 'Electric Drum Kit', 'brand' => 'Roland-style Electronic',
         'desc' => 'Mesh pads with headphone-friendly volume control and built-in sounds.', 'image' => 'images/instruments/dr-electric.webp', 'rate' => 200],
        ['id' => 'dr-acoustic', 'category' => 'drums', 'name' => 'Acoustic Drum Kit', 'brand' => 'Pearl-style 5-piece',
         'desc' => 'Full acoustic kit with hi-hat, crash and ride cymbals.', 'image' => 'images/instruments/dr-acoustic.webp', 'rate' => 180],

        // Keyboards (2)
        ['id' => 'kb-piano', 'category' => 'keyboard', 'name' => 'Yamaha P-125 Digital Piano', 'brand' => 'Yamaha',
         'desc' => '88-key weighted action with realistic piano sound.', 'image' => 'images/instruments/kb-piano.webp', 'rate' => 150],
        ['id' => 'kb-synth', 'category' => 'keyboard', 'name' => 'Roland JUNO-DS61 Synth',    'brand' => 'Roland',
         'desc' => '61-key synthesizer with lots of band-ready sounds and pads.', 'image' => 'images/instruments/kb-synth.webp', 'rate' => 150],

        // Pedals (3)
        ['id' => 'pd-compact', 'category' => 'pedals', 'name' => 'Compact Distortion Pedal', 'brand' => 'Small gear',
         'desc' => 'Small orange stompbox for classic crunch and drive.', 'image' => 'images/instruments/pd-compact.webp', 'rate' => 40],
        ['id' => 'pd-board',   'category' => 'pedals', 'name' => 'Concert Pedalboard',       'brand' => 'Concert pedal rig',
         'desc' => 'Five-pedal board wired and ready for a full show sound.', 'image' => 'images/instruments/pd-board.webp', 'rate' => 120],
        ['id' => 'pd-tank',    'category' => 'pedals', 'name' => 'Tank-G Multi-Effects',     'brand' => 'Tank-G',
         'desc' => 'All-in-one multi-effects unit with five footswitches.', 'image' => 'images/instruments/pd-tank.webp', 'rate' => 100],
    ],
];
