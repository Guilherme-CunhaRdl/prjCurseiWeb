<div class="modal-overlay" id="modalOverlay">
    <div class="modal-content" id="modalContent">
        <button class="close-btn" id="closeModalBtn">
            <i class="fas fa-times"></i>
        </button>

        <!-- Parte 1 - Seleção de Plano -->
        <div id="part1">
            <h2 class="modal-title">Impulsione seu post</h2>
            <div class="cards-container">
                <div class="card" id="card1" onclick="selectCard(1)">
                    <span class="card-title">Impulsionar</span>
                    <span class="card-price">R$ 25,00</span>
                    <span class="card-duration">24 Horas</span>
                </div>
                <div class="card" id="card2" onclick="selectCard(2)">
                    <span class="card-title">Impulsionar</span>
                    <span class="card-price">R$ 57,50</span>
                    <span class="card-duration">3 Dias</span>
                </div>
                <div class="card" id="card3" onclick="selectCard(3)">
                    <span class="card-title">Impulsionar</span>
                    <span class="card-price">R$139,99</span>
                    <span class="card-duration">7 Dias</span>
                </div>
            </div>
            <p class="error-message" id="errorMessage"></p>
            <div class="buttons-container">
                <button class="btn btn-outline" onclick="closeModal()">Cancelar</button>
                <button class="btn btn-primary" onclick="confirmSelection()">Confirmar</button>
            </div>
        </div>

        <!-- Parte 2 - Carregamento -->
        <div class="loading-container hidden" id="part2">
            <img src="{{ asset('img/Icone_Logo_Cursei_Preta.png') }}" alt="Logo" class="logomod" id="logoImg">
            <div class="progress-container">
                <div class="progress-bar" id="progressBar"></div>
            </div>
            <p style="margin-top: 5px; font-weight: 600; font-size: 20px;">Gerando código Pix</p>
        </div>

        <!-- Parte 3 - QR Code -->
        <div class="hidden" id="part3" style="text-align: center;">
            <h2 class="modal-title" style="margin-top: 0px;">Pague via Pix</h2>
            <div class="qr-code-container">
                <img src="https://pngimg.com/d/qr_code_PNG33.png" alt="QR Code" class="qr-code">
            </div>
            <div class="copy-btn" onclick="copyPixCode()">
                Copiar Código Pix
            </div>
            <div class="buttons-container" style="margin-top: 10px;">
                <button class="btn btn-outline" onclick="goBack()">Voltar</button>
                <button class="btn btn-primary" onclick="continuePayment()">Continuar</button>
            </div>
        </div>

        <!-- Parte 4 - Sucesso -->
        <div class="hidden" id="part4" style="text-align: center;">
            <i class="fas fa-check-circle success-icon"></i>
            <h2 class="success-title">Sucesso!</h2>
            <div style="display: flex; align-items: center;justify-content: center;">
                <p class="success-message">Seu post foi impulsionado com sucesso!</p>
            </div>
            <div class="buttons-container" style="margin-top: 20px;">
                <button class="btn btn-outline" onclick="closeModal()">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variáveis de estado
    let selectedCard = null;
    let currentPart = 1;
    const tema = {
        azul: 'var(--inst)',
        texto: 'var(--texto)',
        modalFundo: 'var(--branco)'
    };

    // Elementos do DOM
    const modalOverlay = document.getElementById('modalOverlay');
    const modalContent = document.getElementById('modalContent');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const errorMessage = document.getElementById('errorMessage');
    const parts = {
        part1: document.getElementById('part1'),
        part2: document.getElementById('part2'),
        part3: document.getElementById('part3'),
        part4: document.getElementById('part4')
    };
    const cards = {
        card1: document.getElementById('card1'),
        card2: document.getElementById('card2'),
        card3: document.getElementById('card3')
    };
    const progressBar = document.getElementById('progressBar');

    // Event Listeners
    openModalBtn.addEventListener('click', openModal);
    closeModalBtn.addEventListener('click', closeModal);

    // Funções
    function openModal() {
        modalOverlay.classList.add('active');
        resetModal();
    }

    function closeModal() {
        modalOverlay.classList.remove('active');
    }

    function resetModal() {
        currentPart = 1;
        selectedCard = null;
        errorMessage.textContent = '';

        // Resetar seleção de cards
        Object.values(cards).forEach(card => {
            card.classList.remove('selected');
            card.style.backgroundColor = tema.modalFundo;
        });

        // Mostrar apenas a parte 1
        Object.values(parts).forEach(part => part.classList.add('hidden'));
        parts.part1.classList.remove('hidden');
    }

    function selectCard(cardNumber) {
        selectedCard = cardNumber;

        // Resetar todos os cards
        Object.values(cards).forEach(card => {
            card.classList.remove('selected');
            card.style.backgroundColor = tema.modalFundo;

            // Resetar cores do texto
            const elements = card.querySelectorAll('.card-title, .card-price, .card-duration');
            elements.forEach(el => {
                if (el.classList.contains('card-title')) {
                    el.style.color = tema.azul;
                } else {
                    el.style.color = tema.texto;
                }
            });
        });

        // Selecionar o card clicado
        const selected = cards[`card${cardNumber}`];
        selected.classList.add('selected');
        selected.style.backgroundColor = tema.azul;

        // Mudar cores do texto para branco no card selecionado
        const elements = selected.querySelectorAll('.card-title, .card-price, .card-duration');
        elements.forEach(el => {
            el.style.color = 'white';
        });

        errorMessage.textContent = '';
    }

    function confirmSelection() {
        if (!selectedCard) {
            errorMessage.textContent = 'Escolha uma das opções acima';
            return;
        }

        // Ir para parte 2
        currentPart = 2;
        parts.part1.classList.add('hidden');
        parts.part2.classList.remove('hidden');

        // Simular progresso
        let progress = 0;
        const interval = setInterval(() => {
            progress += 5;
            progressBar.style.width = `${progress}%`;

            if (progress >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    // Ir para parte 3 após o carregamento
                    currentPart = 3;
                    parts.part2.classList.add('hidden');
                    parts.part3.classList.remove('hidden');
                }, 500);
            }
        }, 100);
    }

    function goBack() {
        currentPart = 1;
        parts.part3.classList.add('hidden');
        parts.part1.classList.remove('hidden');
    }

    function continuePayment() {
        
        try {
            
            const dados = {
                idPost: idPost,
                dias: selectedCard
            }
            const result = axios.post(`http://${host}/api/cursei/posts/impulsionar`,dados)

            currentPart = 4;
            parts.part3.classList.add('hidden');
            parts.part4.classList.remove('hidden');
        } catch (error) {

        }
    }

    function copyPixCode() {
        const pixCode = '00020126580014BR.GOV.BCB.PIX0110cursei202752040000530398654051.005802BR5920CURSEI OFICIAL LTDA6009SÃO PAULO62070503***6304ABCD';
        navigator.clipboard.writeText(pixCode)
            .then(() => {
                alert('Código Pix copiado para a área de transferência!');
            })
            .catch(err => {
                console.error('Erro ao copiar código Pix:', err);
            });
    }
</script>
</body>

</html>