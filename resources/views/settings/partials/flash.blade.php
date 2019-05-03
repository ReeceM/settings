<nav class="level is-mobile">
    <div class="level-item">
        @if (session('settings:flash:state', '') != '')
            <div class="message is-small {{ session('settings:flash:state', '') }}">
                <p class="message-body">
                    {{ session('settings:flash:message', '') }}
                </p>
            </div>
        @endif
        <div id="settings_message" hidden>
            <span id="settings_message_text" class="subtitle is-6"></span>
            <span id="settings_message_tag" class="tag"></span>
        </div>
    </div>
</nav>