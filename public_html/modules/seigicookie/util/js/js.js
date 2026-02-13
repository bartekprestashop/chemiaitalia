var s_interval = setInterval(
    function(){
        if(document.readyState == 'complete'){
            clearInterval(s_interval);
            seigi_init_js();
        }
    },100);
function seigi_init_js() {
    try {
        document.querySelectorAll('.s-group-container .s-group-toggle').forEach((a) => {
            a.addEventListener('click', hideblock);
        });
    } catch (e) {}
    try {
        document.querySelectorAll('.left_menu li.active li.page-nav a').forEach((a) => {
            a.addEventListener('click', goTo)
        });
    } catch (e) {}
    try {
        if (document.querySelector('.multilang_change')) {
            Object.values(document.getElementsByClassName('multilang_change')).forEach((a) => a.addEventListener('change', function () {
                changeLang(this)
            }));
            changeLang(document.querySelector('.multilang_change'));
        }
    } catch (e) {}
    try {
        if(document.querySelector('.left_menu li.active')){
            let offset_el = document.querySelector('.left_menu').querySelectorAll('li.active')
            offset_el = offset_el[offset_el.length -1].closest('ul');
            let nav = document.querySelector('.left_menu nav');
            nav.scroll(0, offset_el.getBoundingClientRect().y - nav.getBoundingClientRect().y - 50);
        }
    } catch (e) {}
    try {
        if (document.querySelector('.left_menu li.active').querySelector('li.page-nav')) {
            followScroll();
            window.addEventListener('scroll', followScroll, {passive: true})
        }
    } catch (e) {}
    document.querySelectorAll('input[type="text"][data-sync]').forEach((a) =>{
        let col = document.querySelector('input[type="color"][name="'+a.dataset.sync+'"]');
        a.sync = col;
        col.sync = a;
        a.addEventListener('keyup',function(){
            if(!this.validity.patternMismatch)
                this.sync.value = this.value;
        });
        a.addEventListener('blur',function(){
            if(this.validity.patternMismatch)
                this.value = this.sync.value;
        });
        col.addEventListener('change',function(){
            this.sync.value = this.value
        });
    });

    if(document.querySelector('#content .page-head')) {
        window.addEventListener("scroll", topHide, {passive: true});
        topHide();
    }
    initFieldGroups();
}

function hideblock(item){
    item.target.closest('.s-group-container').classList.toggle('closed');
}

function goTo(e){
    e.preventDefault();
    if(this.parentElement.classList.contains('active'))
        return false;
    var el = document.getElementById(this.attributes['nav-id'].value);
    if(el.querySelector('.s-group-content.s-hidden'))
        el.querySelector('.s-group-header').click();
    el.scrollIntoView();
    window.scrollBy(0, -150)
    return false;
}

function s_show_hidden(e){
    var speed = 500, shown = false;
    let block = e.nextElementSibling;
    shown = block.classList.contains('show');
    if(!shown){
        let h = block.firstElementChild.getBoundingClientRect().height + 27;
        block.style.transition = "height "+h/speed*1000+"ms";
        block.style.height = h+"px";
        block.classList.add('show');
        e.firstElementChild.innerText = e.attributes.hide.value;
        e.lastElementChild.classList.add('icon-chevron-up');
        e.lastElementChild.classList.remove('icon-chevron-down');
    }else{
        block.style.height = null;
        block.classList.remove('show');
        e.firstElementChild.innerText = e.attributes.show.value;
        e.lastElementChild.classList.add('icon-chevron-down');
        e.lastElementChild.classList.remove('icon-chevron-up');
    }
    return false;
}

function followScroll(){
    var class_name = 'scrolled-in';
    var skip = false;
    document.querySelectorAll('.right_content form > *').forEach(function(a) {
        a.classList.remove(class_name)
        if(!skip){
            var b = a.querySelector('.s-group-header').getBoundingClientRect();
            if (b.y + a.getBoundingClientRect().height > 200){
                a.classList.add(class_name);
                let nav = document.querySelector('.left_menu li.active');
                var last_active = nav.querySelector('li.page-nav.active');
                if(last_active)
                    last_active.classList.remove('active');
                nav.querySelector('li.page-nav a[nav-id="'+a.id+'"]').parentElement.classList.add('active')
                skip = true
            }
        }
    })
}
function menuSearch() {
    var input, filter, li, a, i, txtValue;
    input = document.getElementById('menusearch');
    filter = input.value.toUpperCase();
    li = document.querySelector('#content .left_menu').querySelectorAll('ul.top > li');

    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
function changeLang(e){
    var index = e.options.selectedIndex;
    var val = e.value;
    Object.values(document.getElementsByClassName('multilang_change')).forEach((a) => {a.options.selectedIndex = index})
    document.querySelectorAll('.multilang input, .multilang textarea').forEach((a) => {if(a.lang != val){a.style.display='none'}else{a.style.display=null}})
}
function startAutoComplete(){
    new autoComplete({
        selector: '.right_content .input-dropdown',
        minChars: 0,
        cache: 0,
        source: function(term, suggest){
            var el = document.activeElement;
            const json = window[el.dataset.json];
            const length = el.dataset.maxLength || 500;
            term = term.toLowerCase();
            var matches = [];
            json.forEach((json)=>{
                if(matches.length > length)return;
                if (~json.toLowerCase().indexOf(term)) {
                    matches.push(json);
                }
            });
            suggest(matches);
        }
    });
}
function setLangsTranslations(){
    document.querySelectorAll('textarea[name^="tran"]').forEach((a)=>{
        a.addEventListener('blur', function (e){
            var b=this.closest('.trans-block');
            if(this.value.length > 0){b.classList.add('filled')}else{b.classList.remove('filled')}
            var c = b.closest('.s-group-container');
            if(c.querySelectorAll('.trans-block:not(.filled)').length === 0){
                c.classList.add('filled');
            }else{
                c.classList.remove('filled');
            }
        })
    });
    document.getElementById('toggle-trans').addEventListener('click', function() {
        document.body.classList.toggle("hide-filled");
        var a = this.innerText;
        this.innerText = this.dataset.altName;
        this.dataset.altName=a;
    });
}
let lastKnownScrollPosition = 0;
function topHide(event){
    var move = lastKnownScrollPosition - window.scrollY / 4;
    lastKnownScrollPosition = window.scrollY / 4;
    document.querySelectorAll('#content .page-head').forEach((el) => {
        var h = el.dataset.height;
        if (!h) {
            var h = el.getBoundingClientRect().height;
            el.dataset.height = h;
        }
        el.dataset.offset = Math.min(Math.max(parseInt((el.dataset.offset || 0) - move), 0), el.dataset.height);
        el.style.transform = 'translateY(-' + parseInt(el.dataset.offset) + 'px)';
    });
    var el = document.querySelector('#content .page-head');
    var offset = el.dataset.height-el.dataset.offset + 50 + 'px';
    document.querySelector('body').style.setProperty('--top-offset', offset);
}
function openSeigiNav(el){
    var el_class = el+'-open';
    var s_css = document.getElementsByClassName('seigi_css')[0];
    s_css.classList.toggle(el_class);
    if(s_css.classList.value.indexOf('-open') >= 0)
        document.body.style.overflow = 'hidden';
    else
        document.body.style.overflow = null;

}
function initFieldGroups(){
    var field_groups = document.querySelectorAll('.seigi_form .s-field-group');
    if(field_groups.length < 0) return;

    function activateFieldGroup(){
        let content_box = this.closest('.s-field-group-content');
        content_box.querySelectorAll('.s-field-group-tab.active').forEach(a => a.classList.remove('active'));
        this.classList.add('active');
        content_box.querySelectorAll('.s-field-group-fields .sformfield.active').forEach(a => a.classList.remove('active'));
        content_box.querySelector('.s-field-group-fields .sformfield [name="'+this.dataset.field+'"]').closest('.sformfield').classList.add('active');
    }

    field_groups.forEach((a) => {
        a.querySelectorAll('.s-field-group-tab').forEach((b) => b.addEventListener('click', activateFieldGroup));
        a.querySelector('.s-field-group-tab').click();
    })
}
