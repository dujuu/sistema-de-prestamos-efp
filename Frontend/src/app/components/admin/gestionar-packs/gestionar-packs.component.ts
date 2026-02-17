import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { NavbarAdminComponent } from '../navbar-admin/navbar-admin.component';
import { AsignaturasService } from '../../../services/asignaturas.service';

@Component({
  selector: 'app-gestionar-packs',
  standalone: true,
  imports: [CommonModule, FormsModule, NavbarAdminComponent],
  templateUrl: './gestionar-packs.component.html',
  styleUrls: ['./gestionar-packs.component.css']
})
export class GestionarPacksComponent implements OnInit {

  /* ================================
               DATA BACKEND
  ================================== */
  equipos: any[] = [];
  packs: any[] = []; // lista de packs existentes

  /* ================================
               ESTADOS
  ================================== */
  packSeleccionado: any = null;
  creandoPack = false;

  /* ================================
               FORMULARIO DE CREACIÓN
  ================================== */
  form: any = {
    nombre: '',
    equipos: [] as any[]
  };

  equipoSeleccionado: any = null;

  constructor(private service: AsignaturasService) {}

  ngOnInit(): void {
    this.cargarDatos();
  }

  cargarDatos() {
    this.service.getEquipos().subscribe((r: any) => this.equipos = r);

    // NO EXISTE GET PACKS EN BACKEND → MOCK TEMPORAL
    this.packs = [];
  }

  /* ================================
           NUEVO PACK
  ================================== */
  nuevoPack() {
    this.creandoPack = true;
    this.packSeleccionado = null;

    this.form = {
      nombre: '',
      equipos: []
    };

    this.equipoSeleccionado = null;
  }

  /* ================================
           SELECCIONAR PACK
  ================================== */
  seleccionarPack(pack: any) {
    this.packSeleccionado = pack;
    this.creandoPack = false;
  }

  /* ================================
           AGREGAR EQUIPO AL PACK
  ================================== */
  agregarEquipo() {
    if (!this.equipoSeleccionado) return;

    // ❗ AGREGAR SIEMPRE COMO UN NUEVO ITEM (packs NO usan cantidad)
    const nuevo = {
      id: this.equipoSeleccionado.id,
      nombre: this.equipoSeleccionado.nombre
    };

    this.form.equipos.push(nuevo);

    this.equipoSeleccionado = null; // limpiar selección
  }

  eliminarEquipo(i: number) {
    this.form.equipos.splice(i, 1);
  }

  /* ================================
             GUARDAR PACK
  ================================== */
  crearPack() {
    const nuevoPack = {
      id: this.packs.length + 1,
      nombre: this.form.nombre,
      equipos: [...this.form.equipos] // copiar lista
    };

    this.packs.push(nuevoPack);

    alert("Pack creado con éxito");
    this.creandoPack = false;
  }

  /* ================================
             ELIMINAR PACK
  ================================== */
  eliminarPack(id: number) {
    const confirmDelete = confirm("¿Eliminar este pack?");
    if (!confirmDelete) return;

    this.packs = this.packs.filter(p => p.id !== id);
    this.packSeleccionado = null;

    alert("Pack eliminado.");
  }
}
