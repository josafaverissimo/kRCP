async function sendData(formData, target) {
    const response = await fetch(target, {
        method: "post",
        body: formData
    })
    return await response.json()
}

document.addEventListener("DOMContentLoaded", () => {
    const mainForm = document.getElementById("main-form")

    mainForm.addEventListener("submit", event => {
        event.preventDefault()
        const form = event.target

        const formData = new FormData();
        formData.append("username", form.username.value)
        formData.append("password", form.password.value)

        sendData(formData, form.action).then(json => {
            console.log(json)
        })
    })
})