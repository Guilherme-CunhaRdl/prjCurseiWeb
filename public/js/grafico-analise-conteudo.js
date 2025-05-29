const ctx = document.getElementById('graficoCurtidas').getContext('2d');

// Dados vindos do backend
const posts = window.postsMaisCurtidos.map(post => post.titulo_post);
const curtidas = window.postsMaisCurtidos.map(post => post.total_curtidas);

// Criar o gráfico
new Chart(ctx, {
    type: 'bar', // Tipo do gráfico (barra)
    data: {
        labels: posts, // Títulos dos posts
        datasets: [{
            label: 'Curtidas',
            data: curtidas, // Quantidade de curtidas
            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Cor das barras
            borderColor: 'rgba(54, 162, 235, 1)', // Cor da borda
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
            maintainAspectRatio: false, // ESSENCIAL para respeitar a altura do containe
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            title: {
                display: true,
                text: 'Posts Mais Curtidos'
            }
        },
        scales: {
            y: {
                beginAtZero: true // Começar o eixo Y no zero
            }
        }
    }
});