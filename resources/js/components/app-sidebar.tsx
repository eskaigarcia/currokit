import { BookOpen, FolderGit2, LayoutGrid } from 'lucide-react';
import { PanelLeftCloseIcon, PanelLeftOpenIcon } from 'lucide-react';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

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
        <Sidebar collapsible="icon" variant="inset" className="top-16 h-[calc(100svh-4rem)]">
            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} />
                <SidebarMenu>
                    <SidebarMenuItem>
                        <CollapseButton />
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarFooter>
        </Sidebar>
    );
}
