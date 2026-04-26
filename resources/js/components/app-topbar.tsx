import { Link, usePage } from '@inertiajs/react';
import AppLogo from '@/components/app-logo';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/hooks/use-initials';
import { cn } from '@/lib/utils';
import { home } from '@/routes';
import { edit as editProfile } from '@/routes/profile';

const navItems = [
    { label: 'Mis tableros', href: '/tableros' },
    { label: 'Empresas', href: '/empresas' },
    { label: 'Educación', href: '/educacion' },
];

export function AppTopBar() {
    const { auth } = usePage().props;
    const currentUrl = usePage().url;
    const getInitials = useInitials();

    return (
        <header className="sticky top-0 z-20 flex h-16 shrink-0 items-center border-b bg-background px-6">
            <Link href={home()} className="mr-8">
                <AppLogo className="h-7 w-auto" />
            </Link>

            <nav className="flex flex-1 items-center gap-1">
                {navItems.map(({ label, href }) => (
                    <Link
                        key={href}
                        href={href}
                        className={cn(
                            'rounded px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground',
                            currentUrl.startsWith(href)
                                ? 'bg-accent text-accent-foreground'
                                : 'text-muted-foreground',
                        )}
                    >
                        {label}
                    </Link>
                ))}
            </nav>

            {auth.user && (
                <Link
                    href={editProfile()}
                    className="flex cursor-pointer items-center gap-3 rounded py-2 px-4 transition-colors hover:bg-accent focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                >
                    <div className="flex flex-col text-right leading-tight">
                        <span className="text-sm font-medium">{auth.user.name}</span>
                        <span className="text-xs text-muted-foreground">{auth.user.points} puntos</span>
                    </div>
                    <Avatar className="h-8 w-8">
                        <AvatarImage
                            src={auth.user.avatar}
                            alt={auth.user.name}
                        />
                        <AvatarFallback className="rounded-full bg-neutral-200 text-sm text-black dark:bg-neutral-700 dark:text-white">
                            {getInitials(auth.user.name)}
                        </AvatarFallback>
                    </Avatar>
                </Link>
            )}
        </header>
    );
}
