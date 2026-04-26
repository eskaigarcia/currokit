import { AppContent } from '@/components/app-content';
import { AppShell } from '@/components/app-shell';
import { AppSidebar } from '@/components/app-sidebar';
import { AppTopBar } from '@/components/app-topbar';
import type { AppLayoutProps } from '@/types';

export default function AppSidebarLayout({ children }: AppLayoutProps) {
    return (
        <div className="flex h-svh flex-col overflow-hidden">
            <AppTopBar />
            <AppShell variant="sidebar" className="min-h-0 flex-1 bg-muted">
                <AppSidebar />
                <AppContent variant="sidebar" className="overflow-x-hidden overflow-y-auto min-h-0">
                    {children}
                </AppContent>
            </AppShell>
        </div>
    );
}
