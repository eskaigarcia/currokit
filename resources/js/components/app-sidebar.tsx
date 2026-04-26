import { Link } from '@inertiajs/react';
import {
    Bell,
    BookmarkCheck,
    Briefcase,
    Building2,
    HelpCircle,
    LayoutGrid,
    PanelLeftCloseIcon,
    PanelLeftOpenIcon,
    Settings,
    Share2,
    Star,
    Trophy,
} from 'lucide-react';
import { NavSection } from '@/components/nav-section';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/hooks/use-current-url';
import type { NavItem } from '@/types';

const generalItems: NavItem[] = [
    { title: 'Todas mis empresas', href: '/empresas', icon: Building2 },
    { title: 'Todas mis ofertas', href: '/ofertas', icon: Briefcase },
];

const tablerosItems: NavItem[] = [
    { title: 'Mis tableros', href: '/tableros', icon: LayoutGrid },
    { title: 'Destacados', href: '/tableros/destacados', icon: Star },
    { title: 'Compartido conmigo', href: '/tableros/compartidos', icon: Share2 },
];

const educacionItems: NavItem[] = [
    { title: 'Guardado', href: '/educacion/guardado', icon: BookmarkCheck },
];

const bottomItems: NavItem[] = [
    { title: 'Logros', href: '/logros', icon: Trophy },
    { title: 'Notificaciones', href: '/notificaciones', icon: Bell },
    { title: 'Configuración', href: '/configuracion', icon: Settings },
    { title: 'Ayuda y soporte', href: '/ayuda', icon: HelpCircle },
];

function Divider() {
    return <div className="h-px shrink-0 bg-sidebar-border" />;
}

function BottomNavItem({ item }: { item: NavItem }) {
    const { isCurrentOrParentUrl } = useCurrentUrl();

    return (
        <SidebarMenuItem>
            <SidebarMenuButton
                asChild
                isActive={isCurrentOrParentUrl(item.href)}
                tooltip={{ children: item.title }}
            >
                <Link href={item.href} prefetch>
                    {item.icon && <item.icon />}
                    <span>{item.title}</span>
                </Link>
            </SidebarMenuButton>
        </SidebarMenuItem>
    );
}

function CollapseButton() {
    const { toggleSidebar, state } = useSidebar();
    const collapsed = state === 'collapsed';

    return (
        <SidebarMenuButton onClick={toggleSidebar} tooltip={collapsed ? 'Expandir panel' : 'Colapsar panel'}>
            {collapsed ? <PanelLeftOpenIcon /> : <PanelLeftCloseIcon />}
            <span>{collapsed ? 'Expandir panel' : 'Colapsar panel'}</span>
        </SidebarMenuButton>
    );
}

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset" className="top-16 h-[calc(100svh-4rem)] overflow-x-hidden">
            <SidebarContent>
                <NavSection label="General" items={generalItems} />
                <Divider />
                <NavSection label="Tableros" items={tablerosItems} />
                <Divider />
                <NavSection label="Educación" items={educacionItems} />
            </SidebarContent>

            <SidebarFooter>
                <Divider />

                {/* Rate limits widget */}
                <div className="group-data-[collapsible=icon]:hidden px-2 py-1">
                    {/* TODO: rate limits widget */}
                </div>

                <SidebarMenu>
                    {bottomItems.map((item) => (
                        <BottomNavItem key={item.title} item={item} />
                    ))}
                    <SidebarMenuItem>
                        <CollapseButton />
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarFooter>
        </Sidebar>
    );
}
