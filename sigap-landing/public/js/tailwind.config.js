/**
 * SIGAP BRIDA - Tailwind Custom Configuration
 * Palet Warna Putih Tulang (Bone White) & Maroon Kota Makassar
 */
tailwind.config = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
            },
            colors: {
                bone: {
                    50: '#FDFDFB',
                    100: '#FAF9F5', // Putih Tulang Utama
                    200: '#F5F4EE', // Putih Tulang Sekunder
                    300: '#EBE9E1', // Border halus
                    400: '#DDD9CF',
                    500: '#C5C0B3',
                },
                maroon: {
                    50: '#FDF2F4',
                    100: '#FBE8EC',
                    200: '#F6D2DA',
                    600: '#991B1B',
                    700: '#800020', // Warna Maroon Utama
                    800: '#6B001A', // Maroon Gelap (Hover)
                    900: '#520013',
                    950: '#3D000E',
                },
                makassar: {
                    red: '#E11D48',
                    dark: '#1E293B',
                    gold: '#D97706'
                }
            }
        }
    }
};
