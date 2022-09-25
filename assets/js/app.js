
import '../css/app.scss';

import { Dropdown } from 'bootstrap';
import { async } from 'regenerator-runtime';

document.addEventListener('DOMContentLoaded', () => {
    new App();
    $('.dropdown-toggle').dropdown()
})

class App {
    constructor() {
        this.handleCommentForm()
    }

    handleCommentForm() {

        const commentForm = document.querySelector('form.comment-form')


        if (null == commentForm) {
            return
        }

        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault()
            
            const response = await fetch('/ajax/comments', {
                method: 'POST',
                body: new FormData(e.target)
            }) 

            if (!response.ok){
                return;
            }  

            const json = await response.json()


            if (json.code == 'COMMENT_ADDED_SUCCESSFULLY'){
                const commentList = document.querySelector('.comment-list')
                const commentCount = document.querySelector('.comment-count')
                const commentContent = document.querySelector('#comment-content')
                commentList.insertAdjacentHTML('beforeend', json.message)
                commentList.lastElementChild.scrollIntoView()
                commentCount.innerText = json.NumberOfComments + 'commentaire(s)'
                commentContent.value = ""
            }
        })
        
    }
    
}


