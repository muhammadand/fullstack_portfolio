import re

with open('/Users/muhammadandi/Project web/fullstack_portfolio/resources/views/blogs/create.blade.php', 'r') as f:
    content = f.read()

# Replace max-w-4xl with max-w-6xl
content = content.replace('max-w-4xl', 'max-w-6xl')

# Background
content = content.replace('bg-gray-50', 'bg-white')

# Fonts
content = content.replace('text-2xl', 'text-xl tracking-tight')
content = content.replace('text-xl', 'text-lg')
content = content.replace('text-sm text-gray-600', 'text-[13px] text-slate-500')
content = content.replace('text-sm font-medium', 'text-[13px] font-medium tracking-wide text-slate-700')
content = content.replace('text-sm', 'text-[13px]')
content = content.replace('text-xs', 'text-[11px]')

# Accents (Purple -> Midnight Blue / Slate-900)
content = content.replace('purple-600', 'slate-900')
content = content.replace('purple-500', 'slate-800')
content = content.replace('purple-700', 'slate-800')
content = content.replace('purple-300', 'slate-300')
content = content.replace('purple-50', 'slate-50')
content = content.replace('#9333ea', '#0f172a') # slate-900
content = content.replace('#7e22ce', '#1e293b') # slate-800
content = content.replace('#6b21a8', '#334155') # slate-700

# Button smoothing
content = content.replace('rounded-lg hover:bg-slate-800 focus:outline-none', 'rounded-xl hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 focus:outline-none')
content = content.replace('rounded-lg border border-gray-300 hover:bg-gray-50 focus:outline-none', 'rounded-xl border border-slate-200 hover:bg-slate-50 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 focus:outline-none')
content = content.replace('rounded-lg', 'rounded-xl')

# Write back
with open('/Users/muhammadandi/Project web/fullstack_portfolio/resources/views/blogs/create.blade.php', 'w') as f:
    f.write(content)

print("Updated successfully")
