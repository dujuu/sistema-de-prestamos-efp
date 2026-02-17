import { Component, computed, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { ReservasService } from '../solicitar-reserva/reservas.service';
import { Equipo } from '../../../shared/models';
import { AuthService } from '../../../services/auth.service';

@Component({
  selector: 'app-catalogo-equipos',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './catalogo-equipos.component.html',
  styleUrls: ['./catalogo-equipos.component.css']
})
export class CatalogoEquiposComponent {
  private reservas = inject(ReservasService);
  private router = inject(Router);
  private api = inject(AuthService);

  
  equipos = signal<Equipo[]>([]);
  categoriaSeleccionada = signal<string>('TODOS');
  carrito = signal<number[]>([]);
  busqueda = signal<string>('');

  
  ngOnInit() {
    const token = localStorage.getItem('token') ?? '';
    if (!token) {
      alert('⚠️ Debes iniciar sesión para ver los equipos.');
      this.router.navigate(['/auth/login']);
      return;
    }

    this.api.getEquipos(token).subscribe({
      next: (data) => {
        this.equipos.set(data);
      },
      error: (err) => {
        console.error('❌ Error al obtener equipos:', err);
      },
    });
  }

  categorias = computed(() => {
    const todas = this.equipos().map(e => e.categoria);
    return ['TODOS', ...new Set(todas)];
  });

  equiposFiltrados = computed(() => {
    const texto = this.busqueda().toLowerCase();
    const categoria = this.categoriaSeleccionada();
    return this.equipos().filter(e => {
      const coincideCategoria = categoria === 'TODOS' || e.categoria === categoria;
      const coincideTexto =
        e.nombre.toLowerCase().includes(texto) ||
        e.codigo.toLowerCase().includes(texto);
      return coincideCategoria && coincideTexto;
    });
  });


  filtrarPorCategoria(cat: string) {
    this.categoriaSeleccionada.set(cat);
  }


  filtrarPorBusqueda(event: Event) {
    const input = event.target as HTMLInputElement;
    this.busqueda.set(input.value);
  }


  toggleEquipo(id: number) {
    const actuales = this.carrito();
    if (actuales.includes(id)) {
      this.carrito.set(actuales.filter(x => x !== id));
    } else {
      this.carrito.set([...actuales, id]);
    }
  }
  getImagenEquipo(equipo: any): string {
    const nombre = equipo.nombre?.toLowerCase() || '';

    if (nombre.includes('notebook') || nombre.includes('lenovo')) return 'assets/equipos/notebook.jpg';
    if (nombre.includes('raspberry') || nombre.includes('raspberry')) return 'assets/equipos/raspberry.jpg';
    if (nombre.includes('lego') || nombre.includes('lego')) return 'assets/equipos/lego.jpg';
    if (nombre.includes('monitor') || nombre.includes('monitor')) return 'assets/equipos/monitor.jpg';
    if (nombre.includes('pc') || nombre.includes('hp')) return 'assets/equipos/pc.png';


    // Si no coincide con ninguno, usa una de respaldo cualquiera
    return 'assets/equipos/lampara.jpg';
  }



  
  estaSeleccionado(id: number): boolean {
    return this.carrito().includes(id);
  }

  
  continuarReserva() {
    if (this.carrito().length === 0) {
      alert('⚠️ Debes seleccionar al menos un equipo antes de continuar.');
      return;
    }

    this.router.navigate(['/reservas/solicitar'], {
      state: { equiposSeleccionados: this.carrito() }
    });
  }
}
