import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-navbar-admin',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './navbar-admin.component.html',
  styleUrls: ['./navbar-admin.component.css']
})
export class NavbarAdminComponent {

  menuAbierto = false;

  toggleMenu() {
    this.menuAbierto = !this.menuAbierto;
  }

  /** 🔹 Enviar evento al dashboard para cambiar de sección interna */
  navegarInterno(seccion: string) {
    this.menuAbierto = false;

    window.dispatchEvent(
      new CustomEvent('admin-navegacion', { detail: seccion })
    );
  }

  /** 🔹 Cerrar sesión */
  cerrarSesion() {
    if (confirm('¿Deseas cerrar sesión?')) {
      window.location.href = '/auth/login';
    }
  }
}
