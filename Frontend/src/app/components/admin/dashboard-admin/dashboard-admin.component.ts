import { Component, OnInit, OnDestroy, inject } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { NavbarAdminComponent } from '../navbar-admin/navbar-admin.component';
import { SolicitudesPendientesComponent } from '../solicitudes-pendientes/solicitudes-pendientes.component';
import { SolicitudesFinalizadasComponent } from '../solicitudes-finalizadas/solicitudes-finalizadas.component';
import { InventarioComponent } from '../inventario/inventario.component';
import { CuentasComponent } from '../cuentas/cuentas.component';
import { PreguntasFrecuentesAdminComponent } from '../preguntas-frecuentes-admin/preguntas-frecuentes-admin.component';  // ✅ NUEVO

import { AuthService } from '../../../services/auth.service';

@Component({
  selector: 'app-dashboard-admin',
  standalone: true,
  imports: [
    CommonModule,
    FormsModule,
    RouterLink,
    NavbarAdminComponent,
    SolicitudesPendientesComponent,
    SolicitudesFinalizadasComponent,
    InventarioComponent,
    CuentasComponent,
    PreguntasFrecuentesAdminComponent  // ✅ IMPORTADO
  ],
  templateUrl: './dashboard-admin.component.html',
  styleUrls: ['./dashboard-admin.component.css']
})
export class DashboardAdminComponent implements OnInit, OnDestroy {

  private router = inject(Router);
  private api = inject(AuthService);

  // 🔹 Secciones internas del dashboard
  seccionActiva:
    'gestionar' |
    'solicitudes' |
    'finalizadas' |
    'inventario' |
    'cuentas' |
    'preguntas-frecuentes' = 'gestionar';     // ✅ NUEVO

  // Estadísticas
  totalEquipos = 0;
  totalSancionesActivas = 0;

  // Listener para eventos del navbar
  listener: any;

  ngOnInit(): void {
    this.cargarEquipos();
    this.cargarSancionesActivas();

    /** 🔹 NAVBAR -> Dashboard */
    this.listener = (e: any) => {
      switch (e.detail) {

        case 'gestionar':
          this.seccionActiva = 'gestionar';
          break;

        case 'solicitudes':
          this.seccionActiva = 'solicitudes';
          break;

        case 'finalizadas':
          this.seccionActiva = 'finalizadas';
          break;

        case 'inventario':
          this.seccionActiva = 'inventario';
          break;

        case 'cuentas':
          this.seccionActiva = 'cuentas';
          break;

        case 'asignaturas':
          this.irGestionarAsignaturas();
          break;

        /** ⭐ NUEVO: Preguntas Frecuentes */
        case 'preguntas-frecuentes':
          this.seccionActiva = 'preguntas-frecuentes';
          break;
      }
    };

    window.addEventListener('admin-navegacion', this.listener);
  }

  ngOnDestroy(): void {
    if (this.listener) {
      window.removeEventListener('admin-navegacion', this.listener);
    }
  }

  /** 🔹 Cargar número de sanciones activas */
  private cargarSancionesActivas(): void {
    const token = localStorage.getItem('token') ?? '';

    this.api.getSancionesActivas(token).subscribe({
      next: (data) => this.totalSancionesActivas = data.length,
      error: (err) => console.error('Error al cargar sanciones activas:', err)
    });
  }

  /** 🔹 Cargar número de equipos */
  private cargarEquipos(): void {
    const token = localStorage.getItem('token') ?? '';

    this.api.getEquipos(token).subscribe({
      next: (data) => this.totalEquipos = data.length,
      error: (err) => console.error('Error al cargar equipos:', err)
    });
  }

  /** 🔹 Cerrar sesión */
  cerrarSesion() {
    if (confirm('¿Seguro deseas cerrar sesión?')) {
      this.router.navigate(['/auth/login']);
    }
  }

  /** 🔹 Navegar hacia la vista de asignaturas/eventos */
  irGestionarAsignaturas() {
    this.router.navigate(['/admin/asignaturas']);
  }
}
