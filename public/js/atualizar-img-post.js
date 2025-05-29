document.getElementById('imgPost').addEventListener('change', readImagePost, false);

const textarea = document.querySelector('.inserirInfoPost');
textarea.addEventListener('input', function () {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});

function readImagePost(){
    if(this.files && this.files[0]){
        var file = new FileReader();

        file.onload = function(e){
            document.querySelectorAll('.imgPost').forEach(function(img){
                img.src = e.target.result;
            })
        };
        file.readAsDataURL(this.files[0])
    }
}