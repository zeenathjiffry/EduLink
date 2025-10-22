
    <div class="createPopUp">
      <div id="documentPopup" class="popup">
        <div class="popup-content">
          <span class="close" onclick="closeCreatePopup('documentPopup')"
            >&times;</span
          >
          <h2>Create Document</h2>

           <form id="documentForm" method="POST" enctype="multipart/form-data" action="<?= ROOT ?>/TeacherVle/uploadDocument">            <div class="form-group">
              <label for="docName">Document Name:</label>
              <input type="text" id="docName" name="docName" required />
            </div>

            <div class="form-group">
              <label for="docDescription">Description:</label>
              <textarea
                id="docDescription"
                name="docDescription"
                rows="3"
                required
              ></textarea>
            </div>

            <div class="form-group">
              <label for="docUpload">Upload File:</label>
              <input
                type="file"
                id="docUpload"
                name="docUpload"
                accept=".pdf,.docx,.pptx,.txt"
                required
              />
            </div>

            <div class="form-group">
              <label for="docExpire">Expire Date:</label>
              <input type="date" id="docExpire" name="docExpire" />
            </div>

            <div class="form-group">
              <label for="docHiddenUntil">Hidden for students until:</label>
              <input type="date" id="docHiddenUntil" name="docHiddenUntil" />
            </div>

            <div class="popup-buttons">
              <button type="submit">Upload</button>
              <button type="button" onclick="closeCreatePopup('documentPopup')">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>

      <div id="UploadPopup" class="popup">
        <div class="popup-content">
          <span class="close" onclick="closeCreatePopup('UploadPopup')"
            >&times;</span
          >
          <h2>Add Upload Link</h2>

          <form id="uploadLinkForm" onsubmit="return false;">
            <div class="form-group">
              <label for="linkName">Link Name:</label>
              <input type="text" id="linkName" name="linkName" required />
            </div>

            <div class="form-group">
              <label for="linkType">Valid Type:</label>
              <select id="linkType" name="linkType" required>
                <option value="">Select type</option>
                <option value="pdf">PDF</option>
                <option value="doc">DOC/DOCX</option>
                <option value="video">Video</option>
                <option value="image">Image</option>
                <option value="any">Any</option>
              </select>
            </div>

            <div class="form-group">
              <label for="linkDescription">Description:</label>
              <textarea
                id="linkDescription"
                name="linkDescription"
                rows="3"
              ></textarea>
            </div>

            <div class="form-group">
              <label for="linkExpire">Expire Date:</label>
              <input type="date" id="linkExpire" name="linkExpire" />
            </div>

            <div class="form-group">
              <label>
                <input type="checkbox" id="linkHiddenCheckbox" /> Hidden from
                students until
              </label>
              <input
                type="date"
                id="linkHiddenUntil"
                name="linkHiddenUntil"
                disabled
              />
            </div>

            <div class="popup-buttons">
              <button type="submit" onclick="uploadLink()">Upload</button>
              <button type="button" onclick="closeCreatePopup('UploadPopup')">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>

      <div id="quizPopup" class="popup">
        <div class="popup-content">
          <span class="close" onclick="closeCreatePopup('quizPopup')"
            >&times;</span
          >
          <h2>Create Quiz</h2>
          <form id="quizForm" onsubmit="return false;">
            <div class="form-group">
              <label for="quizName">Quiz Name:</label>
              <input type="text" id="quizName" name="quizName" required />
            </div>
            <div class="form-group">
              <label for="quizDescription">Description:</label>
              <textarea
                id="quizDescription"
                name="quizDescription"
                rows="3"
              ></textarea>
            </div>
            <div class="form-group">
              <label for="quizTimeLimit">Time Limit (minutes):</label>
              <input
                type="number"
                id="quizTimeLimit"
                name="quizTimeLimit"
                min="1"
                placeholder="e.g., 30"
                required
              />
            </div>
            <div class="form-group">
              <label for="numberOfQuestions">Number of Questions:</label>
              <input
                type="number"
                id="numberOfQuestions"
                name="numberOfQuestions"
                min="1"
                max="20"
                oninput="generateQuestionFields()"
                placeholder="e.g., 5"
                required
              />
            </div>
            <div id="questionsContainer"></div>
            <div class="popup-buttons">
              <button type="submit" onclick="createQuiz()">Create Quiz</button>
              <button type="button" onclick="closeCreatePopup('quizPopup')">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
