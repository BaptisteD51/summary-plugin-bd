window.addEventListener("load",function(){
    let stylingOptions = document.querySelectorAll("input.sumbd-customize-setting")
    let customizeButton = document.getElementById("sumbd-customize-checkbox")

    function deactivateFields(customizeButton,stylingOptions){
        if (customizeButton.checked){
            stylingOptions.forEach((e)=>{
                e.removeAttribute("disabled")
            })
            return
        }else{
            stylingOptions.forEach((e)=>{
                e.setAttribute("disabled",true)
            })
        }
    }

    deactivateFields(customizeButton,stylingOptions)

    customizeButton.addEventListener("change",()=>{
        deactivateFields(customizeButton,stylingOptions)
    })
})