document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('.custom-meta-tabs li');
    var tabContents = document.querySelectorAll('.custom-meta-content .custom-meta-tab');

    tabs.forEach(function (tab, index) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) {
                t.classList.remove('active');
            });

            tab.classList.add('active');

            tabContents.forEach(function (content) {
                content.classList.remove('active');
            });

            tabContents[index].classList.add('active');
        });
    });
});

function typePerson() {
    let $typePerson = document.querySelector('.js-type-person')
    if($typePerson) {

        let $cpf = document.querySelector('.js-cpf')
        let $nascimento = document.querySelector('.js-nascimento')

        let $cnpj = document.querySelector('.js-cnpj')
        let $type_company = document.querySelector('.js-type-company')
        
        $cpf.setAttribute('hidden', '')
        $nascimento.setAttribute('hidden', '')
        $cnpj.setAttribute('hidden', '')
        $type_company.setAttribute('hidden', '')

        let value = $typePerson.value
        if(value == 'FISICA') {
            $cpf.removeAttribute('hidden')
            $nascimento.removeAttribute('hidden')

        }else{
            $cnpj.removeAttribute('hidden')
            $type_company.removeAttribute('hidden')
        }
    }
}

typePerson()