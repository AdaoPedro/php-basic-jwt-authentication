
const form = document.forms[0];
const btnGetResource = document.querySelector("#getResource")

const store = {}

store.setJwt = (data) => {
    store.jwt = data
}

const credential = {
    email: form.email.value,
    password: form.password.value
}

btnGetResource.style.display = "none"

form.addEventListener("submit", async (e) => {
    e.preventDefault()

    const credential = {
        email: form.email.value,
        password: form.password.value
    }

    const response = await fetch(
        "authenticate.php",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: JSON.stringify(credential)
        }
    )

    if (response.status >= 200 && response.status <=299) {
        const message = JSON.parse(
            await response.text()
        )

        console.log(message.jwt)

        store.setJwt(message.jwt)

        form.style.display = "none";
        btnGetResource.style.display = "block"

        return
    }

    console.log(`${response.status} - ${response.statusText}`)
})

btnGetResource.addEventListener("click", async () => {
    const response = await fetch(
        "validate.php",
        {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${store.jwt}`
            }
        }
    )

    if(response.status >= 200 && response.status <= 299) {
        console.log( await response.text())

        return
    }

    console.log(`${response.status} - ${response.statusText}`)

})

