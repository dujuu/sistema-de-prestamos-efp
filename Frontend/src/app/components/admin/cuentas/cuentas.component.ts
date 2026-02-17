/**
 * Componente encargado de la gestión de cuentas de alumnos dentro del sistema.
 * Permite listar, filtrar, paginar, crear y editar usuarios provenientes del backend.
 * 
 * Este componente funciona como módulo standalone y utiliza servicios para
 * conectarse a la API vía UsuariosService.
 */
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { UsuariosService } from '../../../services/usuarios.service';

/**
 * Representa la estructura base de un Alumno/Usuario dentro del sistema.
 */
interface Alumno {
  id: number;
  nombre: string;
  apellido1?: string;
  apellido2?: string;
  email: string;
  rut?: string;
  telefono?: string;
  celular: string;
  carrera?: string;
  password?: string;
  rol?: string;
}
/**
 * Respuesta paginada enviada por el backend.
 */
interface UsuarioResponse {
  data: any[];
  current_page: number;
  last_page: number;
}


@Component({
  selector: 'app-cuentas',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './cuentas.component.html',
  styleUrls: ['./cuentas.component.css']
})
export class CuentasComponent implements OnInit {
   /** Lista completa de alumnos obtenidos desde el backend */
  alumnos: Alumno[] = [];
  /** Alumno seleccionado para visualizar o editar */
  alumnoSeleccionado: Alumno | null = null;

   /** Valor utilizado para el campo de búsqueda */
  filtro: string = '';

  /** Indica si el usuario se encuentra en estado de edición */
  editMode = false;

  /** Indica si el usuario está creando una nueva cuenta */
  creando = false;
    /**
   * Objeto utilizado para la creación de un nuevo alumno.
   * Se inicializa vacío y se completa en el formulario.
   */
  nuevoAlumno: Alumno = {
    id: 0,
    nombre: '',
    apellido1: '',
    apellido2: '',
    email: '',
    rut: '',
    telefono: '',
    celular: '',
    password: '',
    rol: 'Alumno'
  };
  /** Página actual de la tabla */
  currentPage = 1;
    /** Última página disponible según el backend */
  lastPage = 1;
    /**
   * Hook de inicialización del componente.
   * Carga automáticamente la primera página de alumnos.
   */
  constructor(private usuariosService: UsuariosService) {}

  ngOnInit(): void {
    this.cargarAlumnos();
  }

    /**
   * Carga la lista de alumnos desde el backend de acuerdo a la página indicada.
   * @param page Número de página a cargar (por defecto 1)
   */
  cargarAlumnos(page: number = 1) {
    this.usuariosService.obtenerUsuarioss(page).subscribe({
      next: (res) => {
        this.alumnos = res.data;
        this.currentPage = res.current_page;
        this.lastPage = res.last_page;
      },
      error: (err) => console.error('Error cargando alumnos:', err)
    });
  }
    /**
   * Avanza a la siguiente página, si existe.
   */
  paginaSiguiente() {
    if (this.currentPage < this.lastPage) {
      this.currentPage++;
      this.cargarAlumnos(this.currentPage);
    }
  }
    /**
   * Retrocede a la página anterior, si es posible.
   */
  paginaAnterior() {
    if (this.currentPage > 1) {
      this.currentPage--;
      this.cargarAlumnos(this.currentPage);
    }
  }

  /**
   * Retorna el listado filtrado de alumnos según nombre o email.
   * @returns Lista filtrada de alumnos
   */
  get alumnosFiltrados() {
    if (!this.filtro.trim()) return this.alumnos;
    const f = this.filtro.toLowerCase();

    return this.alumnos.filter(a =>
      a.nombre.toLowerCase().includes(f) ||
      a.email.toLowerCase().includes(f)
    );
  }
  /**
   * Selecciona un alumno para visualizar su información.
   * @param a Alumno seleccionado
   */
  seleccionar(a: Alumno) {
    this.alumnoSeleccionado = { ...a };
    this.editMode = false;
    this.creando = false;
  }

  /**
   * Habilita el modo creación y reinicia el formulario correspondiente.
   */
  comenzarCrear() {
    this.creando = true;
    this.alumnoSeleccionado = null;
    this.editMode = false;

  this.nuevoAlumno = {
    id: 0,
    nombre: '',
    apellido1: '',
    apellido2: '',
    email: '',
    rut: '',
    telefono: '',
    celular: '',
    password: '',
    rol: 'Alumno'
  };


  }
  /**
   * Guarda los cambios realizados a un alumno existente enviando la actualización al backend.
   */
  guardar() {
    if (!this.alumnoSeleccionado) return;

    const id = this.alumnoSeleccionado.id;

    const payload = {
      nombre: this.alumnoSeleccionado.nombre,
      apellido1: this.alumnoSeleccionado.apellido1,  
      apellido2: this.alumnoSeleccionado.apellido2,
      rut: this.alumnoSeleccionado.rut,
      email: this.alumnoSeleccionado.email,
      telefono: this.alumnoSeleccionado.telefono,
      celular: this.alumnoSeleccionado.celular,
      password: null,
      rol: this.alumnoSeleccionado.rol  
    };

  this.usuariosService.actualizarUsuario(id, payload)
    .subscribe({
      next: (res) => {
        alert("Usuario actualizado correctamente ✔");
        this.editMode = false;
        this.cargarAlumnos(this.currentPage);
      },
    error: (err) => {
      console.error("Error al actualizar usuario", err);
      console.table(err.error.errors);   
      alert("Error al actualizar usuario (422). Revisa consola.");
    }

    });
}


   /**
   * Envía al backend los datos ingresados para crear un nuevo usuario.
   * Verifica que los campos obligatorios estén completos.
   */
  crearCuenta() {
    if (!this.nuevoAlumno.nombre || !this.nuevoAlumno.email || !this.nuevoAlumno.password) {
      alert('Completa los campos obligatorios.');
      return;
    }

    const payload = {
      nombre: this.nuevoAlumno.nombre,
      apellido1: "Default",       
      apellido2: "",
      rut: this.nuevoAlumno.rut,
      email: this.nuevoAlumno.email,
      telefono: this.nuevoAlumno.telefono,
      password: this.nuevoAlumno.password,
      rol: "alumno"             
    };

    this.usuariosService.crearUsuario(payload).subscribe({
      next: (res) => {
        alert('Cuenta creada correctamente ');
        this.creando = false;
        this.cargarAlumnos(); // recargar tabla
      },
      error: (err) => {
        console.error(err);
        alert("Error al crear usuario");
      }
    });
  }
    /**
   * Habilita el modo de edición para modificar los datos de un alumno.
   */
  editar() {
    this.editMode = true;
  }
}
