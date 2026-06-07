import re

file_path = '/Users/muhammadandi/Project web/fullstack_portfolio/resources/views/portfolio/create.blade.php'

with open(file_path, 'r') as f:
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
content = content.replace('text-sm font-semibold', 'text-[13px] font-semibold tracking-wide text-slate-700')
content = content.replace('text-sm', 'text-[13px]')
content = content.replace('text-xs', 'text-[11px]')

# Accents (Blue -> Midnight Blue / Slate-900)
content = content.replace('blue-600', 'slate-900')
content = content.replace('blue-500', 'slate-800')
content = content.replace('blue-700', 'slate-800')
content = content.replace('blue-300', 'slate-300')
content = content.replace('blue-50', 'slate-50')
content = content.replace('#3b82f6', '#0f172a') # slate-900
content = content.replace('#2563eb', '#1e293b') # slate-800
content = content.replace('#1d4ed8', '#334155') # slate-700

# Button smoothing
content = content.replace('rounded-lg hover:bg-slate-800 focus:outline-none', 'rounded-xl hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 focus:outline-none')
content = content.replace('rounded-lg border border-gray-300 hover:bg-gray-50 focus:outline-none', 'rounded-xl border border-slate-200 hover:bg-slate-50 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 focus:outline-none')
content = content.replace('rounded-lg', 'rounded-xl')

# Write back
with open(file_path, 'w') as f:
    f.write(content)

print("Updated portfolio create.blade.php successfully")
