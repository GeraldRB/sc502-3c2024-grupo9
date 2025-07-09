let contactos = JSON.parse(localStorage.getItem('contactos')) || [];

function renderMensajes() {
  const ul = document.getElementById('listaMensajes');
  ul.innerHTML = '';
  contactos.forEach((c, i) => {
    const li = document.createElement('li');
    li.textContent = `${c.nombre} - ${c.correo}: ${c.mensaje} (Enviado: ${c.fecha_envio})`;
    ul.appendChild(li);
  });
}

document.getElementById('formContacto').addEventListener('submit', e => {
  e.preventDefault();
  const contacto = {
    nombre: document.getElementById('nombre').value,
    correo: document.getElementById('correo').value,
    mensaje: document.getElementById('mensaje').value,
    fecha_envio: new Date().toLocaleString()
  };
  contactos.push(contacto);
  localStorage.setItem('contactos', JSON.stringify(contactos));
  renderMensajes();
  e.target.reset();
});

renderMensajes();