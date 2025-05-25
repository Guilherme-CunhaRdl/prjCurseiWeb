const modalInfo = document.getElementById("modal-perfil-info")
const contmodalInfo = document.getElementById("contmodalInfo")
function abrirModalAlterInfo() {
    contmodalInfo.style.display = "flex"
}


function fecharModalInfo(event) {
    // Fecha o modal apenas se o clique for fora da caixa do modal
    
    if (event.target === document.getElementById('contmodalInfo')) {
        // contmodalInfo.style.animation = "removerModalCont 500ms ease-in-out"
        // modalInfo.style.animation = "tiraModal 500ms ease-in-out"
        
        // setTimeout(() => {
        //     contmodalInfo.style.display = "none"
            
        // }, 450);
        contmodalInfo.style.display ="none"
    }
}

document.getElementById('foto-upload').addEventListener('change', function(e) {
    const preview = document.getElementById('foto-preview');
    const file = e.target.files[0];
    if (file) {
      preview.src = URL.createObjectURL(file);
    }
  });
  
  document.getElementById('banner-upload').addEventListener('change', function(e) {
    const preview = document.getElementById('banner-preview');
    const file = e.target.files[0];
    if (file) {
      preview.src = URL.createObjectURL(file);
    }
  });


  document.addEventListener('DOMContentLoaded', function() {

    const cepInput = document.getElementById('cep');
    cepInput.addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length > 5) {
        value = value.substring(0,5) + '-' + value.substring(5,8);
      }
      e.target.value = value;
    });
  
    const estadoInput = document.getElementById('estado');
    estadoInput.addEventListener('input', function(e) {
      e.target.value = e.target.value.toUpperCase();
    });
  

    document.getElementById('form-endereco').addEventListener('submit', function(e) {

      if (!/^\d{5}-\d{3}$/.test(cepInput.value)) {
        alert('CEP inválido! Formato correto: 12345-678');
        e.preventDefault();
        return;
      }
  

      if (!/^[A-Z]{2}$/.test(estadoInput.value)) {
        alert('Sigla do estado inválida! Deve conter exatamente 2 letras.');
        e.preventDefault();
        return;
      }
  

      const requiredInputs = this.querySelectorAll('[required]');
      for (const input of requiredInputs) {
        if (!input.value.trim()) {
          alert(`O campo ${input.previousElementSibling.textContent} é obrigatório!`);
          input.focus();
          e.preventDefault();
          return;
        }
      }
    });
  });



  document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartMes').getContext('2d');
    
    // Dados estáticos para o gráfico
    const chartMes = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        datasets: [
          {
            label: '2023',
            backgroundColor: '#e74a3b',
            data: [65000, 59000, 80000, 81000, 56000, 55000, 40000, 85000, 92000, 105000, 120000, 110000],
            barPercentage: 0.6
          },
          {
            label: '2024',
            backgroundColor: '#4e73df',
            data: [75000, 69000, 85000, 91000, 76000, 75000, 60000, 95000, 102000, 115000, 130000, 125000],
            barPercentage: 0.6
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            grid: {
              display: false
            }
          },
          y: {
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)'
            },
            ticks: {
              callback: function(value) {
                return value >= 1000 ? (value/1000).toFixed(0) + 'k' : value;
              }
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.raw.toLocaleString() + ' visualizações';
              }
            }
          }
        }
      }
    });
  });

