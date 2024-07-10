import css from 'highlight.js/lib/languages/css'
import javascript from 'highlight.js/lib/languages/javascript'
import json from 'highlight.js/lib/languages/json'
import php from 'highlight.js/lib/languages/php'
import plaintext from 'highlight.js/lib/languages/plaintext'
import xml from 'highlight.js/lib/languages/xml'
import {lowlight} from 'lowlight/lib/core'

lowlight.registerLanguage('css', css)
lowlight.registerLanguage('javascript', javascript)
lowlight.registerLanguage('json', json)
lowlight.registerLanguage('php', php)
lowlight.registerLanguage('plaintext', plaintext)
lowlight.registerLanguage('html', xml)

export {lowlight} from 'lowlight/lib/core'
