<script>
    import {onMount, onDestroy} from "svelte";
    import {createEditor, EditorContent, BubbleMenu} from 'svelte-tiptap';
    import StarterKit from '@tiptap/starter-kit';
    import ScribbleBlock from './extensions/ScribbleBlock';
    import cx from 'clsx';
    import { Subscript } from '@tiptap/extension-subscript'
    import { Superscript } from '@tiptap/extension-superscript'

    let editor;

    // export let blocks;
    export let content;
    export let statePath;

    onMount(() => {
        editor = createEditor({
            content,
            extensions: [
                StarterKit,
                ScribbleBlock,
                Subscript,
                Superscript,
            ],
            onUpdate({editor}) {
                window.dispatchEvent(new CustomEvent('updatedEditor', {
                    detail: {
                        statePath: statePath,
                        content: editor.getHTML(),
                    }
                }));
            },
        })
    })

    // blocks.forEach(e => {
    //     window.addEventListener(`insert-${e.name}`, data => {
    //         $editor.chain().insertScribbleBlock({
    //             type: e.name,
    //             values: data.detail
    //         }).focus().run();
    //     })
    //
    //     window.addEventListener(`update-${e.name}`, data => {
    //         $editor.chain().updateScribbleBlock({
    //             values: data.detail
    //         })
    //
    //         window.dispatchEvent(new CustomEvent('updateBlock', {
    //             detail: e.name
    //         }));
    //     })
    // })

    $: isActive = (name, attrs = {}) => $editor.isActive(name, attrs);

    const toggleBold = () => {
        $editor.chain().focus().toggleBold().run();
    }

    const toggleItalic = () => {
        $editor.chain().focus().toggleItalic().run();
    }

    const toggleStrike = () => {
        $editor.chain().focus().toggleStrike().run();
    }

    const toggleCode = () => {
        $editor.chain().focus().toggleCode().run();
    }

    const toggleSuperscript = () => {
        $editor.chain().focus().toggleSuperscript().run();
    }

    const toggleSubscript = () => {
        $editor.chain().focus().toggleSubscript().run();
    }

    const buttonClasses = 'rounded-sm p-1 text-white bg-transparent hover:text-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500';
</script>

<div class="scribble-wrapper">
    <EditorContent editor={$editor} />
    {#if $editor}
    <BubbleMenu editor={$editor}>
        <div class="flex items-center">
            <button
                type="button"
                on:click={toggleBold}
                class="{cx(buttonClasses, {'!text-primary-400': isActive('bold')})}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 11H12.5C13.8807 11 15 9.88071 15 8.5C15 7.11929 13.8807 6 12.5 6H8V11ZM18 15.5C18 17.9853 15.9853 20 13.5 20H6V4H12.5C14.9853 4 17 6.01472 17 8.5C17 9.70431 16.5269 10.7981 15.7564 11.6058C17.0979 12.3847 18 13.837 18 15.5ZM8 13V18H13.5C14.8807 18 16 16.8807 16 15.5C16 14.1193 14.8807 13 13.5 13H8Z"/>
                </svg>
            </button>
            <button
                type="button"
                on:click={toggleItalic}
                class="{cx(buttonClasses, {'!text-primary-400': isActive('italic')})}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M15 20H7V18H9.92661L12.0425 6H9V4H17V6H14.0734L11.9575 18H15V20Z"/>
                </svg>
            </button>
            <button
                type="button"
                on:click={toggleStrike}
                class="{cx(buttonClasses, {'!text-primary-400': isActive('strike')})}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.1538 14C17.3846 14.5161 17.5 15.0893 17.5 15.7196C17.5 17.0625 16.9762 18.1116 15.9286 18.867C14.8809 19.6223 13.4335 20 11.5862 20C9.94674 20 8.32335 19.6185 6.71592 18.8555V16.6009C8.23538 17.4783 9.7908 17.917 11.3822 17.917C13.9333 17.917 15.2128 17.1846 15.2208 15.7196C15.2208 15.0939 15.0049 14.5598 14.5731 14.1173C14.5339 14.0772 14.4939 14.0381 14.4531 14H3V12H21V14H17.1538ZM13.076 11H7.62908C7.4566 10.8433 7.29616 10.6692 7.14776 10.4778C6.71592 9.92084 6.5 9.24559 6.5 8.45207C6.5 7.21602 6.96583 6.165 7.89749 5.299C8.82916 4.43299 10.2706 4 12.2219 4C13.6934 4 15.1009 4.32808 16.4444 4.98426V7.13591C15.2448 6.44921 13.9293 6.10587 12.4978 6.10587C10.0187 6.10587 8.77917 6.88793 8.77917 8.45207C8.77917 8.87172 8.99709 9.23796 9.43293 9.55079C9.86878 9.86362 10.4066 10.1135 11.0463 10.3004C11.6665 10.4816 12.3431 10.7148 13.076 11H13.076Z"/>
                </svg>
            </button>
            <button
                type="button"
                on:click={toggleSuperscript}
                class="{cx(buttonClasses, {'!text-primary-400': isActive('superscript')})}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5.59567 5L10.5 10.9283L15.4043 5H18L11.7978 12.4971L18 19.9943V20H15.4091L10.5 14.0659L5.59092 20H3V19.9943L9.20216 12.4971L3 5H5.59567ZM21.5507 6.5803C21.7042 6.43453 21.8 6.22845 21.8 6C21.8 5.55817 21.4418 5.2 21 5.2C20.5582 5.2 20.2 5.55817 20.2 6C20.2 6.07624 20.2107 6.14999 20.2306 6.21983L19.0765 6.54958C19.0267 6.37497 19 6.1906 19 6C19 4.89543 19.8954 4 21 4C22.1046 4 23 4.89543 23 6C23 6.57273 22.7593 7.08923 22.3735 7.45384L20.7441 9H23V10H19V9L21.5507 6.5803V6.5803Z"/>
                </svg>
            </button>
            <button
                type="button"
                on:click={toggleSubscript}
                class="{cx(buttonClasses, {'!text-primary-400': isActive('subscript')})}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5.59567 4L10.5 9.92831L15.4043 4H18L11.7978 11.4971L18 18.9943V19H15.4091L10.5 13.0659L5.59092 19H3V18.9943L9.20216 11.4971L3 4H5.59567ZM21.8 16C21.8 15.5582 21.4418 15.2 21 15.2C20.5582 15.2 20.2 15.5582 20.2 16C20.2 16.0762 20.2107 16.15 20.2306 16.2198L19.0765 16.5496C19.0267 16.375 19 16.1906 19 16C19 14.8954 19.8954 14 21 14C22.1046 14 23 14.8954 23 16C23 16.5727 22.7593 17.0892 22.3735 17.4538L20.7441 19H23V20H19V19L21.5507 16.5803C21.7042 16.4345 21.8 16.2284 21.8 16Z"/>
                </svg>
            </button>
            <button
                type="button"
                on:click={toggleCode}
                class="{cx(buttonClasses, {'!text-primary-400': isActive('code')})}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M23 11.9998L15.9289 19.0708L14.5147 17.6566L20.1716 11.9998L14.5147 6.34292L15.9289 4.92871L23 11.9998ZM3.82843 11.9998L9.48528 17.6566L8.07107 19.0708L1 11.9998L8.07107 4.92871L9.48528 6.34292L3.82843 11.9998Z"/>
                </svg>
            </button>
        </div>
    </BubbleMenu>
    {/if}
</div>
