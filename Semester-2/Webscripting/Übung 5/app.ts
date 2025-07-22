function convertCmToInch(): void {
    const input = document.getElementById("inputCm") as HTMLInputElement;
    const output = document.getElementById("outputInch");
    if (output) {
        const valueInCm = parseFloat(input.value);
        const valueInInches = valueInCm / 2.54;
        output.textContent = `${valueInCm} cm is ${valueInInches.toFixed(2)} inches.`;
    }
}

function convertYardToMeter(): void {
    const input = document.getElementById("inputYard") as HTMLInputElement;
    const output = document.getElementById("outputMeter");
    if (output) {
        const valueInYards = parseFloat(input.value);
        const valueInMeters = valueInYards * 0.9144;
        output.textContent = `${valueInYards} yards is ${valueInMeters.toFixed(2)} meters.`;
    }
}

function convertMeterToYard(): void {
    const input = document.getElementById("inputMeter") as HTMLInputElement;
    const output = document.getElementById("outputYard");
    if (output) {
        const valueInMeters = parseFloat(input.value);
        const valueInYards = valueInMeters / 0.9144;
        output.textContent = `${valueInMeters} meters is ${valueInYards.toFixed(2)} yards.`;
    }
}
