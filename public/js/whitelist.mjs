import {h, render, Component} from 'https://cdn.skypack.dev/preact';
import {useState} from 'https://cdn.skypack.dev/preact/hooks';
import {html} from 'https://cdn.skypack.dev/htm/preact';

// Initialize htm with Preact


class App extends Component {
    state = {users: []};


    getUsers = () => {
        this.setState({clicked: true})
    }

    render = () => {
        return html`
            <div class="card-body">
                ${(this.state.whitelist) ? "включен" : "выключен"}
                ${this.state.whitelist ? ` <a href="/diary/whitelist/on/${diaryId}/0">выключить whitelist</a>` :
                    `<a href="/diary/whitelist/on/${diaryId}/1">включить whitelist</a>`}
                <div class="d-flex justify-content-center">
                    <div class="list">
                        <ul>
                            ${this.state.users.map((item) => {
                                return ` <li>${item.name} <a
                                        href="/diary/whitelist/delete/${item.id}/${diaryId}">delete</a></li>`
                            })}
                        </ul>
                    </div>
                    <div class="">
                        <form>
                            <input onkeyup="${this.getUsers(event)}" type="text">
                            <ul class="list-autocomplete">

                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        `
    }
}


render(html`
    <${App}/>`, document.querySelector(".card"));


