async function sendData(formData: FormData, target: string) {
    const response = await fetch(target, {
        method: "post",
        body: formData
    })
    return await response.json()
}

document.addEventListener("DOMContentLoaded", () => {
    const mainForm = document.getElementById("main-form")

    if(!mainForm) {
        return
    }

    mainForm.addEventListener("submit", event => {
        event.preventDefault()

        const formData = new FormData();
        formData.append("username", mainForm.username.value)
        formData.append("password", mainForm.password.value)

        sendData(formData, mainForm.action).then(json => {
            console.log(json)
        })
    })
})