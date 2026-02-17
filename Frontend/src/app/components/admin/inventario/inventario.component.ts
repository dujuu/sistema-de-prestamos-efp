/**
 * Componente encargado de la gestión completa del inventario de equipos.
 * Se encarga de:
 *  - Cargar categorías, tipos y equipos desde el backend.
 *  - Filtrar equipos por área, modelo o búsqueda textual.
 *  - Crear nuevos equipos o modelos, incluyendo subida de imágenes.
 *  - Visualizar y editar grupos de equipos o un equipo individual.
 * 
 * Este módulo representa un punto clave del sistema, ya que gestiona el estado
 * del inventario y establece comunicación directa con los servicios del frontend
 * que, a su vez, interactúan con el backend.
 */

import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { EquiposService } from '../../../services/equipos.service';
import { CategoriaService } from '../../../services/categoria.service';
import { TipoEquipoService } from '../../../services/tipoEquipo.service';

@Component({
  selector: 'app-inventario',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './inventario.component.html',
  styleUrls: ['./inventario.component.css']
})
export class InventarioComponent {

  /** Listas principales utilizadas en el inventario */
  equipos: any[] = [];
  equiposFiltrados: any[] = [];

  categorias: any[] = [];
  todosTipos: any[] = [];
  modelosDeCategoria: any[] = [];

  areas: string[] = [];
  modelos: string[] = [];

  archivoImagen: File | null = null;
  previewImagen: string | null = null;

  busqueda = '';
  filtroArea = '';
  filtroModelo = '';

  modeloSeleccionado: any = null;
  equipoSeleccionado: any = null;
  solicitudActiva: any = null;

  editandoModelo = false;

  modo: 'existente' | 'nuevo' = 'existente';
  panelCrear = false;

  nuevoEquipo: any = {
    categoria_id: '',
    tipo_equipo_id: '',
    nuevoModelo: '',
    codigo: '',
    estado: 'disponible'
  };

  /** =========================
   *  🔔 ALERTA VISUAL (AGREGADO)
   *  ========================= */
  mostrarAlerta = false;
  mensajeAlerta = '';
  tipoAlerta: 'success' | 'error' = 'success';

  constructor(
    private equiposService: EquiposService,
    private categoriaService: CategoriaService,
    private tipoEquipoService: TipoEquipoService
  ) {}

  ngOnInit(): void {
    this.cargarCategorias();
    this.cargarTipos();
    this.cargarEquipos();
  }

  /**  Mostrar alerta visual (AGREGADO) */
  mostrarMensaje(mensaje: string, tipo: 'success' | 'error' = 'success') {
    this.mensajeAlerta = mensaje;
    this.tipoAlerta = tipo;
    this.mostrarAlerta = true;

    setTimeout(() => {
      this.mostrarAlerta = false;
    }, 3000);
  }

  cargarCategorias() {
    this.categoriaService.getCategoriass().subscribe({
      next: (data: any[]) => this.categorias = data,
      error: (err: any) => console.error('Error cargando categorías', err)
    });
  }

  cargarTipos() {
    this.tipoEquipoService.getTipos().subscribe({
      next: (data) => {
        console.log("Tipos desde backend:", data);
        this.todosTipos = data;
      }
    });
  }

  cargarEquipos() {
    this.equiposService.getEquipos().subscribe({
      next: (equipos: any[]) => {
        this.equipos = equipos;
        this.areas = [...new Set(equipos.map(e => e.categoria))];
        this.modelos = [...new Set(equipos.map(e => e.nombre))];
        this.filtrar();
      },
      error: (err: any) => console.error('Error cargando equipos:', err)
    });
  }

  abrirCrearEquipo() {
    this.panelCrear = true;
    this.modeloSeleccionado = null;
    this.equipoSeleccionado = null;
  }

  cerrarCrear() {
    this.panelCrear = false;
  }

  cargarModelosPorCategoria() {
    const categoriaId = this.nuevoEquipo.categoria_id;
    this.modelosDeCategoria = this.todosTipos.filter(t => t.categoria_id == categoriaId);
  }

  cambiarModo() {
    this.modo = this.modo === 'existente' ? 'nuevo' : 'existente';
  }

  onFileSelected(event: any) {
    const file = event.target.files[0];
    if (!file) return;

    this.archivoImagen = file;

    const reader = new FileReader();
    reader.onload = () => this.previewImagen = reader.result as string;
    reader.readAsDataURL(file);
  }

  guardarNuevoEquipo() {
    if (!this.nuevoEquipo.categoria_id || !this.nuevoEquipo.codigo) {
      alert('Complete los campos obligatorios');
      return;
    }

    if (this.modo === 'nuevo') {
      if (!this.nuevoEquipo.nuevoModelo) {
        alert('Ingrese el nombre del nuevo modelo');
        return;
      }

      this.tipoEquipoService.crearTipo(
        {
          nombre: this.nuevoEquipo.nuevoModelo,
          categoria_id: this.nuevoEquipo.categoria_id
        },
        this.archivoImagen ?? undefined
      ).subscribe({
        next: (res: any) => {
          const tipoId = res.tipoEquipo.id;
          this.crearEquipoFinal(tipoId);
        },
        error: (err: any) => console.error('Error creando tipo', err)
      });

    } else {
      this.crearEquipoFinal(this.nuevoEquipo.tipo_equipo_id);
    }
  }

  crearEquipoFinal(tipoId: number) {
    this.equiposService.crearEquipo({
      tipo_equipo_id: tipoId,
      codigo: this.nuevoEquipo.codigo,
      estado: this.nuevoEquipo.estado
    }).subscribe({
      next: () => {
        alert('Equipo creado exitosamente');
        this.cargarEquipos();
        this.limpiarModal();
      },
      error: (err: any) => console.error('Error creando equipo', err)
    });
  }

  limpiarModal() {
    this.nuevoEquipo = {
      categoria_id: '',
      tipo_equipo_id: '',
      nuevoModelo: '',
      codigo: '',
      estado: 'disponible'
    };

    this.archivoImagen = null;
    this.previewImagen = null;
    this.modo = 'existente';
  }

  filtrar() {
    const texto = this.busqueda.toLowerCase();

    this.equiposFiltrados = this.equipos.filter(e =>
      (this.filtroArea === '' || e.categoria === this.filtroArea) &&
      (this.filtroModelo === '' || e.nombre === this.filtroModelo) &&
      (e.nombre.toLowerCase().includes(texto) || e.codigo.toLowerCase().includes(texto))
    );
  }

  get modelosAgrupados() {
    const grupos: any = {};

    this.equiposFiltrados.forEach(e => {
      if (!grupos[e.nombre]) grupos[e.nombre] = [];
      grupos[e.nombre].push(e);
    });

    return Object.keys(grupos).map(modelo => ({
      modelo,
      equipos: grupos[modelo]
    }));
  }

  editarModelo(grupo: any) {
    this.editandoModelo = false;

    this.modeloSeleccionado = {
      nombre: grupo.modelo,
      categoria: grupo.equipos[0].categoria,
      nombreOriginal: grupo.modelo,
      equipos: grupo.equipos.map((e: any) => ({
        idEquipo: e.idEquipo,
        codigo: e.codigo,
        estado: e.estado,
        created_at: e.created_at,
        updated_at: e.updated_at
      }))
    };

    this.equipoSeleccionado = null;
  }

  activarEdicionModelo() {
    this.editandoModelo = true;
  }

  cerrarEdicionModelo() {
    this.editandoModelo = false;
    this.modeloSeleccionado = null;
  }

  guardarCambiosModelo() {
    alert('Cambios aplicados');
    this.cerrarEdicionModelo();
  }

  verDetalle(eq: any) {
    this.equipoSeleccionado = { ...eq };
    this.modeloSeleccionado = null;
  }

  cerrarPanel() {
    this.equipoSeleccionado = null;
    this.solicitudActiva = null;
  }

  /** =========================
   *  💾 GUARDAR CAMBIOS EQUIPO (MODIFICADO)
   *  ========================= */
  guardarCambiosEquipo() {
    this.equiposService.updateEquipo(
      this.equipoSeleccionado.idEquipo,
      {
        codigo: this.equipoSeleccionado.codigo,
        estado: this.equipoSeleccionado.estado
      }
    ).subscribe({
      next: () => {
        this.mostrarMensaje('Equipo actualizado correctamente', 'success');
        this.cargarEquipos();
        this.cerrarPanel();
      },
      error: () => {
        this.mostrarMensaje('Error al guardar los cambios', 'error');
      }
    });
  }

  getImagenEquipo(equipo: any): string {
    const n = equipo.nombre?.toLowerCase() || '';

    if (n.includes('notebook') || n.includes('lenovo')) return 'assets/equipos/notebook.jpg';
    if (n.includes('raspberry')) return 'assets/equipos/raspberry.jpg';
    if (n.includes('lego')) return 'assets/equipos/lego.jpg';
    if (n.includes('monitor')) return 'assets/equipos/monitor.jpg';
    if (n.includes('pc') || n.includes('hp')) return 'assets/equipos/pc.png';

    return 'assets/equipos/lampara.jpg';
  }
}
