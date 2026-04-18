import re

with open('resources/views/admin/page/rooms/form.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

def get_block(text, start, end_mark):
    start_idx = text.find(start)
    if start_idx == -1: return ""
    end_idx = text.find(end_mark, start_idx)
    if end_idx == -1: return ""
    
    # We want to extract just the inner HTML for the block, usually starting from start to end_idx
    block = text[start_idx:end_idx]
    return block.strip()

# We need to precisely grab each block's HTML wrapper.
# Looking at the original file:
basic_info = text[text.find('<h4 class="text-sm uppercase tracking-widest font-black text-slate-400">Basic Information</h4>'):text.find('<!-- Attributes & Capacity (Moved Here) -->')].strip()
# remove trailing </div>s
basic_info = re.sub(r'</div>\s*</div>\s*$', '', basic_info)
basic_info = basic_info.rstrip(' \n\r\t</div>')

attributes = text[text.find('<!-- Attributes & Capacity (Moved Here) -->'):text.find('<!-- Features & Media -->')].strip()
attributes = re.sub(r'</div>\s*</div>\s*$', '', attributes)
attributes = attributes.rstrip(' \n\r\t</div>')

highlights = text[text.find('<h4 class="text-sm uppercase tracking-widest font-black text-slate-400">Highlights & Badges</h4>'):text.find('360° Viewer</h4>')].strip()
highlights = highlights[:highlights.rfind('<h4')].strip()

viewer = text[text.find('360° Viewer</h4>') - 100 : text.find('<h4 class="text-sm uppercase tracking-widest font-black text-slate-400">Primary Image</h4>')].strip()
viewer = viewer[viewer.find('<h4'):].strip()
if viewer.endswith('</div>\n                    </div>'): viewer = viewer[:-len('</div>\n                    </div>')].strip()
if viewer.endswith('</div>'): viewer = viewer[:-6].strip()

image = text[text.find('<h4 class="text-sm uppercase tracking-widest font-black text-slate-400">Primary Image</h4>'):text.find('<h4 class="text-sm uppercase tracking-widest font-black text-slate-400">Amenities with Icons</h4>')].strip()
if image.endswith('</div>\n                    <div class="space-y-6 pt-4">'): image = image[:-len('</div>\n                    <div class="space-y-6 pt-4">')].strip()
if image.endswith('</div>'): image = image[:-6].strip()

amenities = text[text.find('<h4 class="text-sm uppercase tracking-widest font-black text-slate-400">Amenities with Icons</h4>'):text.find('<h4 class="text-sm uppercase tracking-widest font-black text-slate-400">Room Rules (e.g.')].strip()
amenities = amenities[:amenities.rfind('<div class="grid flex-col')].strip()
if amenities.endswith('</div>'): amenities = amenities[:-6].strip()

rules = text[text.find('<h4 class="text-sm uppercase tracking-widest font-black text-slate-400">Room Rules (e.g.'):text.find('Frequently Asked\n                                Questions (FAQs)</h4>')].strip()
rules = rules[:rules.rfind('<div class="space-y-6">')].strip()
if rules.endswith('</div>'): rules = rules[:-6].strip()

faqs = text[text.find('Frequently Asked\n                                Questions (FAQs)</h4>'):text.find('Gallery Images (Up to 4')].strip()
faqs = faqs[faqs.find('<h4'):faqs.rfind('<div class="space-y-6 pt-6">')].strip()
if faqs.endswith('</div>'): faqs = faqs[:-6].strip()

gallery = text[text.find('Gallery Images (Up to 4'):text.find('Room Description</label>')].strip()
gallery = gallery[gallery.find('<h4'):gallery.rfind('<div class="pt-4">')].strip()
if gallery.endswith('</div>'): gallery = gallery[:-6].strip()

desc = text[text.find('Room Description</label>')-70:text.find('<div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-6">')].strip()
desc = desc[desc.find('<div'):].strip()

buttons = text[text.find('<div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-6">'):text.find('</form>')].strip()


with open('c:/xampp/htdocs/niceguesthouse/blocks.py', 'w') as f:
    pass

card_template = """
                <div class="card-premium p-8 mb-8">
                    {content}
                </div>
"""

def wrap_card(content):
    return f'                <div class="card-premium p-8 mb-8">\n                    {content}\n                </div>\n'

new_form_content = text[:text.find('<div class="grid grid-cols-1 gap-8 border-b border-slate-100 pb-8">')]

new_form_content += wrap_card(basic_info)
new_form_content += wrap_card(image)
new_form_content += wrap_card(gallery)
new_form_content += wrap_card(viewer)
new_form_content += wrap_card(highlights)
new_form_content += wrap_card(rules)
new_form_content += wrap_card(attributes)
new_form_content += wrap_card(amenities)
new_form_content += wrap_card(faqs)
new_form_content += wrap_card(desc)
new_form_content += '                ' + buttons + '\n            </form>\n        </div>\n    </div>\n\n'
new_form_content += text[text.find('<script>'):]

# In the original file, the `<div class="card-premium p-8">` opened BEFORE the form.
# We need to change that so the <form> contains multiple cards instead of being inside ONE card.
# Or wait, if we put cards INSIDE the form, and the form is INSIDE the main card, it's a card inside a card.
# The user wants "each section make card sparate".
# So we need to remove the outer `<div class="card-premium p-8">` that wraps the whole form, and only apply it to the sections.
# Let's fix new_form_content:

# Instead of text[:text.find('<div class="grid grid-cols-1 gap-8 border-b border-slate-100 pb-8">')],
# We should take from text start to `<form ...>` line, but REMOVE `<div class="card-premium p-8">`!

header_idx = text.find('<div class="max-w-4xl mx-auto pb-24">')
form_idx = text.find('<form action=')
form_end_idx = text.find('class="space-y-8">') + len('class="space-y-8">')

final_text = text[:header_idx] + '<div class="max-w-4xl mx-auto pb-24">\n'
# Add the header title in its own card or just top text
final_text += '    <div class="mb-6">\n        <h3 class="text-3xl font-bold text-slate-800">'
final_text += "{{ isset($room) ? 'Edit Room Listing' : 'Create New Room Listing' }}</h3>\n"
final_text += '        <p class="text-sm text-slate-500 mt-2">Configure room details, pricing, and guest capacity</p>\n    </div>\n\n'

final_text += '    ' + text[form_idx:form_end_idx] + '\n'
final_text += '        @csrf\n        @if(isset($room)) @method(\'PUT\') @endif\n\n'

# Adding cards:
final_text += '        <!-- Each Section as a Card -->\n'
for content in [basic_info, image, gallery, viewer, highlights, rules, attributes, amenities, faqs, desc]:
    if content:
        # Check if the content has a wrapping div like <div class="space-y-6"> and remove if redundant?
        final_text += wrap_card(content)

final_text += wrap_card(buttons)
final_text += '\n    </form>\n</div>\n\n'
final_text += text[text.find('<script>'):]

with open('resources/views/admin/page/rooms/form.blade.php', 'w', encoding='utf-8') as f:
    f.write(final_text)

print("Done restructuring into separate cards!")
