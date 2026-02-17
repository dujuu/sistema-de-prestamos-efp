@component('mail::message')

# Confirmación de Aprobación de Préstamo  
**Departamento de Diseño Multimedia – Universidad de Tarapacá**

Estimado(a) **{{ $nombre }}**,  
Le informamos que su solicitud de préstamo ha sido **aprobada**.

---

## 📘 **Detalles del Préstamo**
- **Código de Préstamo:** {{ $idPrestamo }}
- **Fecha de Solicitud:** {{ $fechaSolicitud }}
- **Motivo de Aprobación:**  
> *{{ $motivo }}*

## 📦 Equipos Aprobados
@foreach($equipos as $eq)
- **{{ $eq['nombre'] }}** (Código: {{ $eq['codigo'] }})
@endforeach

---

Le recordamos que debe respetar los horarios establecidos y devolver el equipamiento en óptimas condiciones.

Atentamente,  
**Unidad de Préstamos de Equipamiento Docente**  
Universidad de Tarapacá  
@endcomponent
