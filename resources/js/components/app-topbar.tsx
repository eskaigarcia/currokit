import { Link, usePage } from '@inertiajs/react';
import AppLogo from '@/components/app-logo';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { UserMenuContent } from '@/components/user-menu-content';
import { useInitials } from '@/hooks/use-initials';
import { home } from '@/routes';

export function AppTopBar() {
    const { auth } = usePage().props;
    const getInitials = useInitials();

    return (
        <header className="sticky top-0 z-20 flex h-16 shrink-0 items-center border-b bg-background px-6">
            <Link href={home()} className="mr-8">
                <AppLogo className="h-7 w-auto" />
            </Link>

            <nav className="flex flex-1 items-center gap-1">
                {/* Main navigation items */}
            </nav>

            {auth.user && (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <button className="flex cursor-pointer items-center gap-3 rounded py-2 px-4 transition-colors hover:bg-accent focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
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
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" className="min-w-56">
                        <UserMenuContent user={auth.user} />
                    </DropdownMenuContent>
                </DropdownMenu>
            )}
        </header>
    );
}
