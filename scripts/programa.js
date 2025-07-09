let programas = JSON.parse(localStorage.getItem('programas')) || [];

function renderProgramas() {
  const tbody = document.getElementById('tablaProgramas');
  tbody.innerHTML = '';
  programas.forEach((p, i) => {
    const row = `<tr>
      <td>${p.titulo}</td>
      <td>${p.nivel}</td>
      <td>${p.fecha_inicio}</td>
      <td>${p.fecha_fin}</td>
      <td>${p.estado ? 'Sí' : 'No'}</td>
      <td>
        <button onclick="editarPrograma(${i})">Editar</button>
        <button onclick="borrarPrograma(${i})">Eliminar</button>
      </td>
    </tr>`;
    tbody.innerHTML += row;
  });
}

document.getElementById('formPrograma').addEventListener('submit', e => {
  e.preventDefault();
  const id = document.getElementById('id_programa').value;
  const programa = {
    titulo: document.getElementById('titulo').value,
    descripcion: document.getElementById('descripcion').value,
    nivel: document.getElementById('nivel').value,
    fecha_inicio: document.getElementById('fecha_inicio').value,
    fecha_fin: document.getElementById('fecha_fin').value,
    estado: document.getElementById('estado').checked
  };
  if (id === '') {
    programas.push(programa);
  } else {
    programas[id] = programa;
  }
  localStorage.setItem('programas', JSON.stringify(programas));
  renderProgramas();
  e.target.reset();
});

function editarPrograma(index) {
  const p = programas[index];
  document.getElementById('id_programa').value = index;
  document.getElementById('titulo').value = p.titulo;
  document.getElementById('descripcion').value = p.descripcion;
  document.getElementById('nivel').value = p.nivel;
  document.getElementById('fecha_inicio').value = p.fecha_inicio;
  document.getElementById('fecha_fin').value = p.fecha_fin;
  document.getElementById('estado').checked = p.estado;
}

function borrarPrograma(index) {
  programas.splice(index, 1);
  localStorage.setItem('programas', JSON.stringify(programas));
  renderProgramas();
}

renderProgramas();