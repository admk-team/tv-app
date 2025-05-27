const users=["vinod","thapa","bahadur"],memberDiv=document.querySelector(".memberDiv"),addIcon=document.querySelector(".addIcon"),userIcons=()=>{users.reverse(),users.map(e=>{memberDiv.insertAdjacentHTML("afterbegin",`
        <button class="btn"><span>${e}</span></button>
        `)})};addIcon.addEventListener("click",()=>{let e=prompt("please enter your name");null==e||users.includes(e)?alert("username already exist"):(users.push(e),memberDiv.insertAdjacentHTML("afterbegin",`
        <button class="btn"><span>${e}</span></button>
        `))}),userIcons();
