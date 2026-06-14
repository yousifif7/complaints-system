/**
 * Auto-translate paired Arabic/English admin fields.
 * Only overwrites the target field while it is empty or still auto-filled.
 * Users can edit or clear the translated text at any time.
 */
(function () {
    const config = window.autoTranslateConfig;
    if (!config?.enabled) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    let skipManualDetection = false;

    document.querySelectorAll('[data-bilingual-group]').forEach((group) => {
        const arInput = group.querySelector('[data-lang="ar"]');
        const enInput = group.querySelector('[data-lang="en"]');

        if (!arInput || !enInput) {
            return;
        }

        let arTimer;
        let enTimer;

        const canAutoFill = (input) => input.dataset.autoFilled !== 'false';

        const setValue = (input, value) => {
            skipManualDetection = true;
            input.value = value;
            input.dataset.autoFilled = 'true';
            skipManualDetection = false;
        };

        const markManual = (input) => {
            if (!skipManualDetection) {
                input.dataset.autoFilled = 'false';
            }
        };

        if (arInput.value && enInput.value) {
            arInput.dataset.autoFilled = 'false';
            enInput.dataset.autoFilled = 'false';
        } else if (arInput.value && !enInput.value) {
            enInput.dataset.autoFilled = 'true';
        } else if (!arInput.value && enInput.value) {
            arInput.dataset.autoFilled = 'true';
        } else {
            arInput.dataset.autoFilled = 'true';
            enInput.dataset.autoFilled = 'true';
        }

        arInput.addEventListener('input', () => {
            if (arInput.value === '') {
                arInput.dataset.autoFilled = 'true';
            } else {
                markManual(arInput);
            }

            clearTimeout(arTimer);

            if (!canAutoFill(enInput)) {
                return;
            }

            arTimer = setTimeout(async () => {
                const text = arInput.value.trim();

                if (!text) {
                    setValue(enInput, '');
                    return;
                }

                const translation = await requestTranslation(text, 'ar', 'en');
                if (translation !== null && canAutoFill(enInput)) {
                    setValue(enInput, translation);
                }
            }, 650);
        });

        enInput.addEventListener('input', () => {
            if (enInput.value === '') {
                enInput.dataset.autoFilled = 'true';
            } else {
                markManual(enInput);
            }

            clearTimeout(enTimer);

            if (!canAutoFill(arInput)) {
                return;
            }

            enTimer = setTimeout(async () => {
                const text = enInput.value.trim();

                if (!text) {
                    setValue(arInput, '');
                    return;
                }

                const translation = await requestTranslation(text, 'en', 'ar');
                if (translation !== null && canAutoFill(arInput)) {
                    setValue(arInput, translation);
                }
            }, 650);
        });
    });

    async function requestTranslation(text, from, to) {
        try {
            const response = await fetch(config.url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ text, from, to }),
            });

            if (!response.ok) {
                return null;
            }

            const data = await response.json();
            return typeof data.translation === 'string' ? data.translation : null;
        } catch (error) {
            return null;
        }
    }
})();
