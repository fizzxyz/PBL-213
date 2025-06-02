@extends('layouts.home')

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Toggle Edit Mode Button -->
@auth
@if(auth()->user()->hasAnyRole(['admin', 'super_admin']))
<div class="edit-toggle">
    <span>Edit Mode</span>
    <label class="switch">
        <input type="checkbox" id="toggleEditMode" />
        <span class="slider"></span>
    </label>
</div>
@endif
@endauth

<section style="padding: 200px 20px; background: url('{{ asset('storage/' . $homeContent->hero_image) }}') center/cover no-repeat; color: white; text-align: center;">
    <h1 style="font-size: 2.5em; font-weight: bold; color: #FFD700;">Tentang Yayasan {{ $yayasan->name }}</h1>
</section>

<section style="padding: 80px 90px; max-width margin: auto;" class="editable-section" id="sectionSejarah">
    <p style="color: #f9b934; font-size: 1.5rem; font-weight: 600; margin-bottom: 8px;">Sejarah Yayasan</p>
    <p style="color: gray; margin-bottom: 30px;">Berikut ini adalah sejarah Yayasan Darussalam Batam</p>

    <div style="margin-bottom: 60px;">
        {!! $yayasan->sejarah !!}
    </div>
    <button class="edit-btn" data-target="modalEditSejarah">Edit</button>
</section>

<section style="position: relative; background: url('{{ asset('home/yayasan/background3.png') }}') center/cover no-repeat; padding: 100px 20px;" class="editable-section" id="sectionVision">
    <div style="position: absolute; inset: 0; background-color: rgba(128, 128, 128, 0.588); z-index: 1;"></div>

    <div style="position: relative; z-index: 2; max-width: 1000px; margin: auto;">
        <h2 style="text-align: center; font-size: 2rem; margin-bottom: 40px;">
            <span style="color: #c7a003; font-weight: 600;">VISI</span>
            <span style="color: #1e3a8a; font-weight: 600;">& MISI</span>
        </h2>

        <div style="font-size: 1.3rem; color: #000; font-weight: bold;">
            {!! $yayasan->vision !!}
        </div>
        <button class="edit-btn" data-target="modalEditVision">Edit</button>
    </div>
</section>

<section style="margin-top: 100px" class="editable-section" id="sectionTentang">
    <div style="margin: 0 auto; position: relative; z-index: 2; padding: 80px 90px;
    background: url('home/yayasan/background2.png') center top / contain no-repeat;
    background-repeat: no-repeat;
    background-position: top center;
    background-size: contain;
    min-height: 980px;
    position: relative;">
        <h2 style="font-size: 2rem; font-weight: bold; color: #1a1a1a; margin-bottom: 40px; text-align: left;">
            Tentang Yayasan
        </h2>

        <div style="color: #333; line-height: 1.8; font-size: 1rem; text-align: justify;">
            {!! $yayasan->tentang !!}
        </div>
        <button class="edit-btn" data-target="modalEditTentang">Edit</button>
    </div>
</section>

<!-- Modals -->

<!-- Modal Sejarah -->
<div id="modalEditSejarah" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Sejarah Yayasan</h2>
            <span class="close" data-target="modalEditSejarah">&times;</span>
        </div>
        <form action="{{ route('yayasan.update.content') }}" method="POST" id="formSejarah">
            @csrf
            <input type="hidden" name="section" value="sejarah" />
            <input type="hidden" name="content" id="inputSejarah" />
            <div class="form-group">
                <label for="editorSejarah">Sejarah</label>
                <div id="editorSejarah" style="height: 300px;">{!! $yayasan->sejarah !!}</div>
            </div>
            <div class="loading" id="sejarahLoading">Menyimpan...</div>
            <button type="submit" class="btn-primary">Simpan</button>
            <button type="button" class="btn-secondary close" data-target="modalEditSejarah">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Vision -->
<div id="modalEditVision" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Visi & Misi</h2>
            <span class="close" data-target="modalEditVision">&times;</span>
        </div>
        <form action="{{ route('yayasan.update.content') }}" method="POST" id="formVision">
            @csrf
            <input type="hidden" name="section" value="vision" />
            <input type="hidden" name="content" id="inputVision" />
            <div class="form-group">
                <label for="editorVision">Visi & Misi</label>
                <div id="editorVision" style="height: 300px;">{!! $yayasan->vision !!}</div>
            </div>
            <div class="loading" id="visionLoading">Menyimpan...</div>
            <button type="submit" class="btn-primary">Simpan</button>
            <button type="button" class="btn-secondary close" data-target="modalEditVision">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Tentang -->
<div id="modalEditTentang" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Tentang Yayasan</h2>
            <span class="close" data-target="modalEditTentang">&times;</span>
        </div>
        <form action="{{ route('yayasan.update.content') }}" method="POST" id="formTentang">
            @csrf
            <input type="hidden" name="section" value="tentang" />
            <input type="hidden" name="content" id="inputTentang" />
            <div class="form-group">
                <label for="editorTentang">Tentang</label>
                <div id="editorTentang" style="height: 300px;">{!! $yayasan->tentang !!}</div>
            </div>
            <div class="loading" id="tentangLoading">Menyimpan...</div>
            <button type="submit" class="btn-primary">Simpan</button>
            <button type="button" class="btn-secondary close" data-target="modalEditTentang">Batal</button>
        </form>
    </div>
</div>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleEdit = document.getElementById('toggleEditMode');
    const body = document.body;

    toggleEdit.addEventListener('change', function() {
        if (this.checked) {
            body.classList.add('edit-mode');
        } else {
            body.classList.remove('edit-mode');
            closeAllModals();
        }
    });

    // Show modal when clicking edit button
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-target');
            const modal = document.getElementById(modalId);
            if(modal) {
                modal.style.display = 'block';
            }
        });
    });

    // Close modal when clicking close button or cancel button
    document.querySelectorAll('.close').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target');
            if(targetId) {
                const modal = document.getElementById(targetId);
                modal.style.display = 'none';
            }
        });
    });

    // Close modal if clicked outside modal content
    window.addEventListener('click', e => {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    });

    function closeAllModals() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
        });
    }

    const toolbarOptions = [
    [{ header: [1, 2, 3, false] }],
    [{ font: [] }],
    [{ size: ['small', false, 'large', 'huge'] }],
    ['bold', 'italic', 'underline'],
    ['link', 'image'],
    [{ list: 'ordered' }, { list: 'bullet' }],
    ['clean']
    ];

    const quillSejarah = new Quill('#editorSejarah', {
    theme: 'snow',
    modules: { toolbar: toolbarOptions }
    });

    const quillVision = new Quill('#editorVision', {
    theme: 'snow',
    modules: { toolbar: toolbarOptions }
    });

    const quillTentang = new Quill('#editorTentang', {
    theme: 'snow',
    modules: { toolbar: toolbarOptions }
    });


    // Fungsi submit AJAX
    function submitFormAjax(formId, quillInstance, hiddenInputId, loadingId) {
    const form = document.getElementById(formId);
    const loading = document.getElementById(loadingId);

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        document.getElementById(hiddenInputId).value = quillInstance.root.innerHTML;

        // Tampilkan loading
        loading.style.display = 'block';

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                section: form.querySelector('input[name="section"]').value,
                content: document.getElementById(hiddenInputId).value,
            }),
        })
        .then(res => res.json())
        .then(data => {
            loading.style.display = 'none'; // Sembunyikan loading
            if(data.success) {
                alert('Berhasil disimpan!');
                location.reload();
            } else {
                alert('Gagal menyimpan data.');
            }
        })
        .catch(() => {
            loading.style.display = 'none'; // Sembunyikan loading
            alert('Terjadi kesalahan saat menyimpan data.');
        });
    });
}

submitFormAjax('formSejarah', quillSejarah, 'inputSejarah', 'sejarahLoading');
submitFormAjax('formVision', quillVision, 'inputVision', 'visionLoading');
submitFormAjax('formTentang', quillTentang, 'inputTentang', 'tentangLoading');

});
</script>