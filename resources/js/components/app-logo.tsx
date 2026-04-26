export default function AppLogo({ className, color = false }: { className?: string; color?: boolean }) {
    return <img src={color ? "/logo.webp" : "/logo-white.webp"} alt="Currokit" className={className} />;
}
