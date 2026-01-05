// Get CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Modal Helper Functions
function showModal(title, content, onConfirm, type = 'input') {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">${title}</h3>
            ${type === 'input' ? `
                <input type="text" id="modalInput" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="${content}">
            ` : `
                <p class="text-gray-600 mb-4">${content}</p>
            `}
            <div class="flex gap-3 mt-6">
                <button onclick="this.closest('.fixed').remove()" 
                    class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition">
                    Cancel
                </button>
                <button id="modalConfirm" 
                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    ${type === 'confirm' ? 'Confirm' : 'Add'}
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    
    const input = modal.querySelector('#modalInput');
    const confirmBtn = modal.querySelector('#modalConfirm');
    
    if (input) {
        input.focus();
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') confirmBtn.click();
        });
    }
    
    confirmBtn.onclick = () => {
        const value = input ? input.value.trim() : true;
        if (type === 'input' && !value) return;
        modal.remove();
        onConfirm(value);
    };
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('opacity-0', 'transition-opacity');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add Section
function addSection() {
    const courseId = document.getElementById('courseId')?.value;
    if (!courseId) {
        showNotification('Course ID not found!', 'error');
        return;
    }
    
    showModal('Add New Section', 'Enter section title', (title) => {
        fetch('/instructor/sections', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                course_id: courseId,
                title: title,
                description: ''
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Section added successfully!');
                setTimeout(() => location.reload(), 500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to add section. Please try again.', 'error');
        });
    });
}

// Edit Section
function editSection(sectionId) {
    showModal('Edit Section', 'Enter new section title', (title) => {
        fetch(`/instructor/sections/${sectionId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ title: title })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Section updated successfully!');
                setTimeout(() => location.reload(), 500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update section.', 'error');
        });
    });
}

// Delete Section
function deleteSection(sectionId) {
    showModal('Delete Section', 'Are you sure you want to delete this section and all its lectures?', () => {
        fetch(`/instructor/sections/${sectionId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Section deleted successfully!');
                setTimeout(() => location.reload(), 500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to delete section.', 'error');
        });
    }, 'confirm');
}

// Add Lecture
function addLecture(sectionId) {
    showModal('Add New Lecture', 'Enter lecture title', (title) => {
        // Show lecture type selection modal
        const typeModal = document.createElement('div');
        typeModal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        typeModal.innerHTML = `
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Select Lecture Type</h3>
                <div class="grid grid-cols-2 gap-3">
                    <button onclick="createLecture(${sectionId}, '${title.replace(/'/g, "\\'")}', 'video')" 
                        class="p-4 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                        <svg class="w-8 h-8 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Video</span>
                    </button>
                    <button onclick="createLecture(${sectionId}, '${title.replace(/'/g, "\\'")}', 'pdf')" 
                        class="p-4 border-2 border-gray-300 rounded-lg hover:border-red-500 hover:bg-red-50 transition">
                        <svg class="w-8 h-8 mx-auto mb-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium">PDF</span>
                    </button>
                    <button onclick="createLecture(${sectionId}, '${title.replace(/'/g, "\\'")}', 'quiz')" 
                        class="p-4 border-2 border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition">
                        <svg class="w-8 h-8 mx-auto mb-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="font-medium">Quiz</span>
                    </button>
                    <button onclick="createLecture(${sectionId}, '${title.replace(/'/g, "\\'")}', 'assignment')" 
                        class="p-4 border-2 border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition">
                        <svg class="w-8 h-8 mx-auto mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="font-medium">Assignment</span>
                    </button>
                    <button onclick="createLecture(${sectionId}, '${title.replace(/'/g, "\\'")}', 'live')" 
                        class="p-4 border-2 border-gray-300 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition col-span-2">
                        <svg class="w-8 h-8 mx-auto mb-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium">Live Class</span>
                    </button>
                </div>
                <button onclick="this.closest('.fixed').remove()" 
                    class="w-full mt-4 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition">
                    Cancel
                </button>
            </div>
        `;
        document.body.appendChild(typeModal);
    });
}

function createLecture(sectionId, title, type) {
    // Close type selection modal
    document.querySelectorAll('.fixed').forEach(el => el.remove());
    showLectureDetailModal(sectionId, { title: title, type: type });
}

// Edit Lecture
function editLecture(lectureId) {
    fetch(`/instructor/lectures/${lectureId}`, {
        headers: { 'X-CSRF-TOKEN': csrfToken }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showLectureDetailModal(data.lecture.section_id, data.lecture);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to fetch lecture details.', 'error');
    });
}

function showLectureDetailModal(sectionId, lecture) {
    const isEdit = !!lecture.id;
    const type = lecture.type;
    
    const detailModal = document.createElement('div');
    detailModal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    
    let contentHtml = `
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Lecture Title</label>
            <input type="text" id="lectureTitle" value="${lecture.title}" class="w-full px-4 py-2 border rounded-lg">
        </div>
    `;

    if (type === 'video') {
        contentHtml += `
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Video Source</label>
                <select id="videoSource" class="w-full px-4 py-2 border rounded-lg mb-3" onchange="toggleVideoSource(this.value)">
                    <option value="upload" ${!lecture.video_url ? 'selected' : ''}>Upload Video File</option>
                    <option value="url" ${lecture.video_url ? 'selected' : ''}>Video URL (YouTube/Vimeo)</option>
                </select>
                
                <div id="videoUploadArea" class="${lecture.video_url ? 'hidden' : ''}">
                    <input type="file" id="lectureFile" accept="video/*" class="w-full px-4 py-2 border rounded-lg">
                    ${lecture.file_path ? `<p class="text-xs text-blue-600 mt-1">Current: ${lecture.file_path.split('/').pop()}</p>` : ''}
                    <p class="text-xs text-gray-500 mt-1">Max size: 50MB</p>
                </div>
                
                <div id="videoUrlArea" class="${!lecture.video_url ? 'hidden' : ''}">
                    <input type="url" id="lectureUrl" value="${lecture.video_url || ''}" placeholder="https://youtube.com/..." class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                <input type="number" id="lectureDuration" value="${lecture.duration || ''}" class="w-full px-4 py-2 border rounded-lg">
            </div>
        `;
    } else if (type === 'pdf') {
        contentHtml += `
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload PDF</label>
                <input type="file" id="lectureFile" accept="application/pdf" class="w-full px-4 py-2 border rounded-lg">
                ${lecture.file_path ? `<p class="text-xs text-blue-600 mt-1">Current: ${lecture.file_path.split('/').pop()}</p>` : ''}
            </div>
        `;
    } else if (type === 'assignment') {
        contentHtml += `
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Assignment File (Optional)</label>
                <input type="file" id="lectureFile" class="w-full px-4 py-2 border rounded-lg">
                ${lecture.file_path ? `<p class="text-xs text-blue-600 mt-1">Current: ${lecture.file_path.split('/').pop()}</p>` : ''}
            </div>
        `;
    }
    
    contentHtml += `
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
            <textarea id="lectureDescription" class="w-full px-4 py-2 border rounded-lg" rows="3">${lecture.description || ''}</textarea>
        </div>
        <div class="flex items-center mb-4">
            <input type="checkbox" id="lectureIsPreview" ${lecture.is_preview ? 'checked' : ''} class="mr-2">
            <label for="lectureIsPreview" class="text-sm text-gray-700">Allow Free Preview</label>
        </div>
    `;

    detailModal.innerHTML = `
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">${isEdit ? 'Edit' : 'Add'} ${type.charAt(0).toUpperCase() + type.slice(1)} Lecture</h3>
            <form id="lectureDetailForm">
                ${contentHtml}
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="this.closest('.fixed').remove()" 
                        class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition">
                        Cancel
                    </button>
                    <button type="submit" id="submitLecture" 
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                        ${isEdit ? 'Update' : 'Save'} Lecture
                    </button>
                </div>
            </form>
        </div>
    `;
    document.body.appendChild(detailModal);

    window.toggleVideoSource = function(value) {
        document.getElementById('videoUploadArea').classList.toggle('hidden', value !== 'upload');
        document.getElementById('videoUrlArea').classList.toggle('hidden', value !== 'url');
    };

    const form = detailModal.querySelector('#lectureDetailForm');
    form.onsubmit = (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('submitLecture');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="inline-block animate-spin mr-2">↻</span> Saving...';

        const formData = new FormData();
        formData.append('section_id', sectionId);
        formData.append('title', document.getElementById('lectureTitle').value);
        formData.append('type', type);
        
        const fileInput = document.getElementById('lectureFile');
        if (fileInput && fileInput.files[0]) {
            formData.append('file_path', fileInput.files[0]);
        }
        
        const urlInput = document.getElementById('lectureUrl');
        if (urlInput && urlInput.value) {
            formData.append('video_url', urlInput.value);
        }
        
        const durationInput = document.getElementById('lectureDuration');
        if (durationInput && durationInput.value) {
            formData.append('duration', durationInput.value);
        }
        
        const descInput = document.getElementById('lectureDescription');
        if (descInput && descInput.value) {
            formData.append('description', descInput.value);
        }
        
        const previewInput = document.getElementById('lectureIsPreview');
        if (previewInput) {
            formData.append('is_preview', previewInput.checked ? 1 : 0);
        }

        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        fetch(isEdit ? `/instructor/lectures/${lecture.id}` : '/instructor/lectures', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(isEdit ? 'Lecture updated successfully!' : 'Lecture added successfully!');
                setTimeout(() => location.reload(), 500);
            } else {
                showNotification(data.message || 'Failed to save lecture.', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = isEdit ? 'Update Lecture' : 'Save Lecture';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to save lecture.', 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = isEdit ? 'Update Lecture' : 'Save Lecture';
        });
    };
}

// Delete Lecture
function deleteLecture(lectureId) {
    showModal('Delete Lecture', 'Are you sure you want to delete this lecture?', () => {
        fetch(`/instructor/lectures/${lectureId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Lecture deleted successfully!');
                setTimeout(() => location.reload(), 500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to delete lecture.', 'error');
        });
    }, 'confirm');
}

// Continue to Pricing
function continueToPricing() {
    window.location.href = '/instructor/courses/create/pricing';
}

// Drag and Drop Reordering (for future enhancement)
function initDragAndDrop() {
    const sections = document.querySelectorAll('.section-item');
    
    sections.forEach(section => {
        section.draggable = true;
        
        section.addEventListener('dragstart', function(e) {
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
            this.classList.add('opacity-50');
        });
        
        section.addEventListener('dragend', function(e) {
            this.classList.remove('opacity-50');
        });
        
        section.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            this.classList.add('border-2', 'border-blue-400');
        });
        
        section.addEventListener('dragleave', function(e) {
            this.classList.remove('border-2', 'border-blue-400');
        });
        
        section.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-2', 'border-blue-400');
            // Save new order via API
        });
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initDragAndDrop);
