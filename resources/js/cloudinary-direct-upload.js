async function uploadImage(input, file) {
    const form = input.closest('form')
    const csrfToken = input.dataset.csrfToken
        || form?.querySelector('input[name="_token"]')?.value
        || document.querySelector('meta[name="csrf-token"]')?.content

    if (!csrfToken) {
        throw new Error('Token keamanan tidak ditemukan. Muat ulang halaman lalu coba lagi.')
    }

    const signResponse = await fetch(input.dataset.cloudinaryUploadUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ directory: input.dataset.cloudinaryDirectory }),
    })

    if (!signResponse.ok) {
        throw new Error('Cloudinary menolak permintaan tanda tangan upload.')
    }

    const signature = await signResponse.json()
    const body = new FormData()
    body.append('file', file)
    body.append('api_key', signature.api_key)
    body.append('asset_folder', signature.asset_folder)
    body.append('overwrite', 'false')
    body.append('timestamp', signature.timestamp)
    body.append('public_id', signature.public_id)
    body.append('signature', signature.signature)

    const uploadResponse = await fetch(signature.upload_url, {
        method: 'POST',
        body,
    })
    const uploaded = await uploadResponse.json()

    if (!uploadResponse.ok || uploaded.public_id !== signature.public_id) {
        throw new Error(uploaded.error?.message || 'Gagal mengunggah gambar ke Cloudinary.')
    }

    return {
        reference: `cloudinary:${uploaded.public_id}|${signature.timestamp}|${signature.signature}`,
        url: uploaded.secure_url,
    }
}

document.addEventListener('change', async (event) => {
    const input = event.target
    if (!(input instanceof HTMLInputElement) || !input.matches('[data-cloudinary-reference-target]')) return

    const file = input.files?.[0]
    if (!file || input.dataset.cloudinaryUploading === 'true') return

    input.dataset.cloudinaryUploading = 'true'
    input.disabled = true

    const status = document.querySelector(input.dataset.cloudinaryStatusTarget)
    if (status) status.textContent = 'Mengunggah foto...'

    try {
        const uploaded = await uploadImage(input, file)
        const referenceInput = document.querySelector(input.dataset.cloudinaryReferenceTarget)

        if (!referenceInput) {
            throw new Error('Kolom referensi gambar tidak ditemukan.')
        }

        referenceInput.value = uploaded.reference
        referenceInput.dispatchEvent(new Event('input', { bubbles: true }))

        const preview = document.querySelector(input.dataset.cloudinaryPreviewTarget)
        if (preview) {
            preview.src = uploaded.url
            preview.hidden = false
        }

        const current = document.querySelector(input.dataset.cloudinaryCurrentTarget)
        if (current) current.hidden = true
        if (status) status.textContent = 'Foto siap disimpan.'
        input.value = ''
    } catch (error) {
        if (status) status.textContent = error.message
        window.alert(error.message)
    } finally {
        input.disabled = false
        delete input.dataset.cloudinaryUploading
    }
})

document.addEventListener('submit', async (event) => {
    const form = event.target
    if (!(form instanceof HTMLFormElement)) return

    if (form.dataset.cloudinaryReplay === 'true') {
        delete form.dataset.cloudinaryReplay
        return
    }

    const inputs = Array.from(form.querySelectorAll(
        'input[type="file"][data-cloudinary-upload-url]:not([data-cloudinary-reference-target])'
    )).filter((input) => input.files?.length)

    if (inputs.length === 0) return

    event.preventDefault()
    event.stopImmediatePropagation()

    if (form.dataset.cloudinaryUploading === 'true') return
    form.dataset.cloudinaryUploading = 'true'
    const hiddenInputs = []

    try {
        for (const input of inputs) {
            if (!input.name) {
                throw new Error('Kolom input gambar tidak memiliki nama form.')
            }

            for (const file of Array.from(input.files)) {
                const uploaded = await uploadImage(input, file)
                const reference = document.createElement('input')
                reference.type = 'hidden'
                reference.name = input.name
                reference.value = uploaded.reference
                form.append(reference)
                hiddenInputs.push(reference)
            }

            input.disabled = true
        }

        form.dataset.cloudinaryReplay = 'true'
        delete form.dataset.cloudinaryUploading

        if (event.submitter) {
            form.requestSubmit(event.submitter)
        } else {
            form.requestSubmit()
        }
    } catch (error) {
        hiddenInputs.forEach((input) => input.remove())
        inputs.forEach((input) => {
            input.disabled = false
        })
        delete form.dataset.cloudinaryUploading
        window.alert(error.message)
    }
}, true)
