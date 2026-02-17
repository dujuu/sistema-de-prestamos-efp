@component('mail::message')

# Notificación de Rechazo de Préstamo  
**Departamento de Diseño Multimedia – Universidad de Tarapacá**

Estimado(a) **{{ $nombre }}**,  
Lamentamos informar que su solicitud de préstamo ha sido **rechazada**.

---

## 📘 **Detalles de la Solicitud**
- **Código de Préstamo:** {{ $idPrestamo }}
- **Fecha de Solicitud:** {{ $fechaSolicitud }}

## ❗ Motivo del Rechazo
> *{{ $motivo }}*

Si considera que existe un error o requiere solicitar nuevamente un préstamo, puede comunicarse con la unidad correspondiente.

Atentamente,  
**Unidad de Préstamos de Equipamiento Docente**  
Universidad de Tarapacá  
@endcomponent
